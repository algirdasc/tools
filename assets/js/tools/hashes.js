const result = $('#result');

$('#hash-selection').on('click', function () {
    const t = $(this).parent().find('textarea');
    const a = $('#hash-algo').val();
    const h = new Hashes[a];
    h.setUpperCase($('#upper-case').is(':checked'));
    result.text(h.hex(t.val()));
});

$('#hash-b64-encode').on('click', function () {
    const t = $(this).parent().find('textarea');
    try {
        result.text(btoa(unescape(encodeURIComponent(t.val()))));
        t.removeClass('is-invalid');
    } catch (error) {
        t.addClass('is-invalid');
    }
});

$('#hash-b64-decode').on('click', function () {
    const t = $(this).parent().find('textarea');
    try {
        result.text(decodeURIComponent(escape(atob(t.val()))));
        t.removeClass('is-invalid');
    } catch (error) {
        t.addClass('is-invalid');
    }
});

$('#inflate').on('click', function () {
    const btn = $(this);
    const t = $(this).parent().find('textarea');
    if (!t.val()) {
        return;
    }

    setButtonBusy(btn);
    ajax('gzinflate.php',
        {
            'base64': t.val()
        },
        function (response) {
            if ($('#inflate-redirect').is(':checked')) {
                window.location.href = response.redirect;
            } else {
                result.text(response.data);
            }
        },
        handleAjaxError,
        function () {
            setButtonReady(btn);
        }
    )
});

$('#hash-b64-uncompress').on('click', function () {
    const btn = $(this);
    const t = $(this).parent().find('textarea');
    if (!t.val()) {
        return;
    }

    /*try {
        atob(t.val())
        t.removeClass('is-invalid');
    } catch (error) {
        t.addClass('is-invalid');
        return;
    }*/

    setButtonBusy(btn);
    ajax('gzuncompress.php',
        {
            'base64': t.val()
        },
        function (response) {
            if ($('#uncompress-redirect').is(':checked')) {
                window.location.href = response.redirect;
            } else {
                result.text(response.data);
            }
        },
        handleAjaxError,
        function () {
            setButtonReady(btn);
        }
    )
});