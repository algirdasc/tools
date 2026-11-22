// Password / passphrase generator. 100% client-side: crypto.getRandomValues,
// no server round-trips, nothing stored except optional settings in
// localStorage under 'pwgen.settings'.

const PWGEN_SETTINGS_KEY = 'pwgen.settings';

const PW_SETS = {
    lower: 'abcdefghijklmnopqrstuvwxyz',
    upper: 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
    digits: '0123456789',
    special: '!@#$%^&*()-_=+[]{};:,.<>?/',
};

const PW_HOMOGLYPHS = 'Il1O0';

// EFF large wordlist (7776 words) for diceware-style passphrases.
const PW_WORDS_URL = 'https://www.eff.org/files/2016/07/18/eff_large_wordlist.txt';
let pwWordlist = null; // cached in-memory after first fetch

// Unbiased uniform random integer in [0, max) via rejection sampling.
function pwRandInt(max) {
    if (max <= 0) {
        return 0;
    }
    const range = Math.floor(4294967296 / max) * max; // 2^32
    const buf = new Uint32Array(1);
    let x;
    do {
        crypto.getRandomValues(buf);
        x = buf[0];
    } while (x >= range);
    return x % max;
}

function pwPick(str) {
    return str[pwRandInt(str.length)];
}

// Fisher–Yates shuffle with our RNG.
function pwShuffle(chars) {
    for (let i = chars.length - 1; i > 0; i--) {
        const j = pwRandInt(i + 1);
        const tmp = chars[i];
        chars[i] = chars[j];
        chars[j] = tmp;
    }
    return chars;
}

// ---------------------------------------------------------------------------
// Random password
// ---------------------------------------------------------------------------

function pwGeneratePassword() {
    let charset = PW_SETS.lower;
    const required = [pwPick(PW_SETS.lower)]; // guarantee at least one lower

    if ($('#pw-upper').is(':checked')) {
        charset += PW_SETS.upper;
        required.push(pwPick(PW_SETS.upper));
    }
    if ($('#pw-digits').is(':checked')) {
        charset += PW_SETS.digits;
        required.push(pwPick(PW_SETS.digits));
    }
    if ($('#pw-special').is(':checked')) {
        charset += PW_SETS.special;
        required.push(pwPick(PW_SETS.special));
    }

    if ($('#pw-homoglyphs').is(':checked')) {
        charset = charset.split('').filter(c => PW_HOMOGLYPHS.indexOf(c) === -1).join('');
    }

    const length = parseInt($('#pw-length').val(), 10);
    const chars = [];

    for (const c of required) {
        if (chars.length < length && charset.indexOf(c) !== -1) {
            chars.push(c);
        }
    }
    while (chars.length < length) {
        chars.push(pwPick(charset));
    }

    return pwShuffle(chars).join('');
}

// ---------------------------------------------------------------------------
// Passphrase
// ---------------------------------------------------------------------------

async function pwLoadWordlist() {
    if (pwWordlist) {
        return pwWordlist;
    }
    const response = await fetch(PW_WORDS_URL);
    if (!response.ok) {
        throw new Error('Failed to load wordlist (HTTP ' + response.status + ')');
    }
    const text = await response.text();
    // Lines look like "11111\tabacus"
    pwWordlist = text.split('\n')
        .map(line => line.split('\t')[1])
        .filter(w => w && /^[a-z]+$/.test(w));
    return pwWordlist;
}

async function pwGeneratePassphrase() {
    const words = await pwLoadWordlist();
    const maxLen = parseInt($('#pp-maxlen').val(), 10);
    const count = parseInt($('#pp-count').val(), 10);
    const separator = $('#pp-separator').val();
    const pool = words.filter(w => w.length <= maxLen);

    if (!pool.length) {
        throw new Error('No words fit the max length');
    }

    const picked = [];
    for (let i = 0; i < count; i++) {
        picked.push(pool[pwRandInt(pool.length)]);
    }

    if ($('#pp-capitalize').is(':checked')) {
        for (let i = 0; i < picked.length; i++) {
            picked[i] = picked[i][0].toUpperCase() + picked[i].slice(1);
        }
    }

    let phrase = picked.join(separator);

    if ($('#pp-numbers').is(':checked')) {
        phrase += (separator === '' ? '-' : separator) + pwRandInt(100);
    }
    if ($('#pp-special').is(':checked')) {
        phrase += pwPick(PW_SETS.special);
    }

    return phrase;
}

// ---------------------------------------------------------------------------
// Results UI
// ---------------------------------------------------------------------------

function pwRenderResults(values) {
    const container = $('#pw-results');
    container.empty();

    for (const value of values) {
        const row = $('<div class="input-group mb-2"></div>');
        const input = $('<input type="text" class="form-control" readonly>');
        input.val(value);
        const btn = $('<button class="btn btn-outline-primary" type="button"><i class="bi bi-clipboard"></i></button>');
        btn.on('click', function () {
            navigator.clipboard.writeText(value);
            showToastHtml('<i class="bi bi-hand-thumbs-up-fill"></i> Copied to clipboard', 'bg-success');
        });
        row.append(input).append(btn);
        container.append(row);
    }
}

// ---------------------------------------------------------------------------
// Settings persistence
// ---------------------------------------------------------------------------

function pwCollectSettings() {
    return {
        upper: $('#pw-upper').is(':checked'),
        digits: $('#pw-digits').is(':checked'),
        special: $('#pw-special').is(':checked'),
        homoglyphs: $('#pw-homoglyphs').is(':checked'),
        length: $('#pw-length').val(),
        capitalize: $('#pp-capitalize').is(':checked'),
        numbers: $('#pp-numbers').is(':checked'),
        ppSpecial: $('#pp-special').is(':checked'),
        separator: $('#pp-separator').val(),
        count: $('#pp-count').val(),
        maxlen: $('#pp-maxlen').val(),
    };
}

function pwApplySettings(s) {
    $('#pw-upper').prop('checked', !!s.upper);
    $('#pw-digits').prop('checked', !!s.digits);
    $('#pw-special').prop('checked', !!s.special);
    $('#pw-homoglyphs').prop('checked', !!s.homoglyphs);
    $('#pw-length').val(s.length || 20).trigger('input');
    $('#pp-capitalize').prop('checked', !!s.capitalize);
    $('#pp-numbers').prop('checked', !!s.numbers);
    $('#pp-special').prop('checked', !!s.ppSpecial);
    $('#pp-separator').val(s.separator ?? '-');
    $('#pp-count').val(s.count || 4);
    $('#pp-maxlen').val(s.maxlen || 8);
}

// ---------------------------------------------------------------------------
// Wire up
// ---------------------------------------------------------------------------

$('#pw-length').on('input', function () {
    $('#pw-length-label').text($(this).val());
});

$('#function-gen-password').on('click', function () {
    const results = [];
    for (let i = 0; i < 5; i++) {
        results.push(pwGeneratePassword());
    }
    pwRenderResults(results);
});

$('#function-gen-passphrase').on('click', async function () {
    try {
        const results = [];
        for (let i = 0; i < 5; i++) {
            results.push(await pwGeneratePassphrase());
        }
        pwRenderResults(results);
    } catch (e) {
        showToast('Passphrase failed: ' + e.message, 'bg-danger');
    }
});

$('#function-save-settings').on('click', function () {
    localStorage.setItem(PWGEN_SETTINGS_KEY, JSON.stringify(pwCollectSettings()));
    showToastHtml('<i class="bi bi-save"></i> Settings saved', 'bg-success');
});

// Restore saved settings on load.
try {
    const saved = JSON.parse(localStorage.getItem(PWGEN_SETTINGS_KEY) || 'null');
    if (saved) {
        pwApplySettings(saved);
    }
} catch (e) {
    // ignore corrupt settings
}

// Initial batch so the page isn't empty.
$('#function-gen-password').trigger('click');
