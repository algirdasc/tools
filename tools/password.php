<?php /* Password & passphrase generator — everything runs client-side (Web Crypto). */ ?>
<div class="row">
    <div class="col-6">
        <h5><i class="bi bi-key"></i> Random password</h5>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="pw-upper" checked>
            <label class="form-check-label" for="pw-upper">Include uppercase letters</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="pw-digits" checked>
            <label class="form-check-label" for="pw-digits">Include digits</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="pw-special" checked>
            <label class="form-check-label" for="pw-special">Include special characters</label>
        </div>
        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" id="pw-homoglyphs">
            <label class="form-check-label" for="pw-homoglyphs">Exclude homoglyphs (<code>l1I0O</code>…)</label>
        </div>
        <div class="mb-2">
            <label class="form-label mb-0" for="pw-length">Length: <strong id="pw-length-label">20</strong></label>
            <input type="range" class="form-range" id="pw-length" min="8" max="64" value="20">
        </div>
        <button type="button" class="btn btn-primary" id="function-gen-password">
            <i class="bi bi-arrow-repeat"></i> Generate
        </button>
    </div>
    <div class="col-6">
        <h5><i class="bi bi-card-text"></i> Passphrase</h5>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="pp-capitalize" checked>
            <label class="form-check-label" for="pp-capitalize">Capitalize words</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="pp-numbers" checked>
            <label class="form-check-label" for="pp-numbers">Include a number</label>
        </div>
        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" id="pp-special">
            <label class="form-check-label" for="pp-special">Include a special character</label>
        </div>
        <div class="row g-2 mb-2">
            <div class="col-4">
                <label class="form-label mb-0" for="pp-separator">Separator</label>
                <select id="pp-separator" class="form-control">
                    <option value="-" selected>-</option>
                    <option value=".">.</option>
                    <option value="_">_</option>
                    <option value=" ">space</option>
                    <option value="">none</option>
                </select>
            </div>
            <div class="col-4">
                <label class="form-label mb-0" for="pp-count">Word count</label>
                <select id="pp-count" class="form-control">
                    <?php for ($i = 3; $i <= 8; $i++) { ?>
                        <option value="<?= $i ?>" <?= $i === 4 ? 'selected' : '' ?>><?= $i ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-4">
                <label class="form-label mb-0" for="pp-maxlen">Max word length</label>
                <select id="pp-maxlen" class="form-control">
                    <?php for ($i = 4; $i <= 10; $i++) { ?>
                        <option value="<?= $i ?>" <?= $i === 8 ? 'selected' : '' ?>><?= $i ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <button type="button" class="btn btn-primary" id="function-gen-passphrase">
            <i class="bi bi-arrow-repeat"></i> Generate
        </button>
    </div>
</div>
<div class="row mt-3">
    <div class="col-12">
        <h5><i class="bi bi-clipboard"></i> Results</h5>
        <div class="alert alert-secondary mb-2">
            Generated entirely in your browser with the Web Crypto API — nothing is sent to or stored on the server.
        </div>
        <div id="pw-results"></div>
        <button type="button" class="btn btn-outline-secondary btn-sm mt-2" id="function-save-settings">
            <i class="bi bi-save"></i> Save settings (this browser)
        </button>
    </div>
</div>
