<div class="row h-100">
    <div class="col-4">
        <h5><i class="bi bi-key"></i> Hashes</h5>
        <select id="hash-algo" class="form-control mb-1">
            <option value="MD5">MD5</option>
            <option value="SHA1">SHA1</option>
            <option value="SHA256">SHA256</option>
            <option value="SHA512">SHA512</option>
            <option value="RMD160">RIPEMD-160</option>
        </select>
        <div class="input-group mb-1">
            <textarea id="hash-input" class="form-control"></textarea>
            <button class="btn btn-outline-primary" type="button" id="hash-selection"><i class="bi bi-activity"></i></button>
        </div>
        <input type="checkbox" id="upper-case" />
        <label class="form-check-label" for="upper-case">
            Uppercase result
        </label>
        <hr />
        <h5><i class="bi bi-sort-numeric-down"></i> Base64 Encode</h5>
        <div class="input-group">
            <textarea class="form-control"></textarea>
            <button class="btn btn-outline-primary" type="button" id="hash-b64-encode"><i class="bi bi-activity"></i></button>
        </div>
        <hr />
        <h5><i class="bi bi-sort-alpha-up"></i> Base64 Decode</h5>
        <div class="input-group">
            <textarea class="form-control"></textarea>
            <button class="btn btn-outline-primary" type="button" id="hash-b64-decode"><i class="bi bi-activity"></i></button>
        </div>
        <hr />
        <h5><i class="bi bi-archive"></i> Base64 / HEX Decode & gzinflate</h5>
        <div class="input-group">
            <textarea class="form-control"></textarea>
            <button class="btn btn-outline-primary" type="button" id="hash-b64-inflate"><i class="bi bi-activity"></i></button>
        </div>
        <input type="checkbox" id="inflate-redirect" checked />
        <label class="form-check-label" for="inflate-redirect">
            Redirect
        </label>
        <hr />
        <h5><i class="bi bi-archive"></i> Base64 / HEX Decode & gzuncompress</h5>
        <div class="input-group">
            <textarea class="form-control"></textarea>
            <button class="btn btn-outline-primary" type="button" id="hash-b64-uncompress"><i class="bi bi-activity"></i></button>
        </div>
        <input type="checkbox" id="uncompress-redirect" checked />
        <label class="form-check-label" for="uncompress-redirect">
            Redirect
        </label>
    </div>
    <div class="col-8 h-100">
        <div class="border p-3 bg-light h-100">
            <pre><code class="text-break d-block overflow-auto" id="result" style="max-height: 90vh;"></code></pre>
        </div>
    </div>
</div>