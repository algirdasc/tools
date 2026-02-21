<div class="d-flex flex-row mb-3">
    <div class="btn-group me-3">
        <button type="button" class="btn btn-primary" id="function-auto-format" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Auto Format"><i class="bi bi-text-indent-left"></i></button>
        <button type="button" class="btn btn-primary" id="function-share" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Share"><i class="bi bi-share"></i></button>
        <button type="button" class="btn btn-primary" id="function-word-wrap" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Word wrap"><i class="bi bi-card-text"></i></button>
        <button type="button" class="btn btn-primary" id="function-n-to-newline" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Replace \n with new line"><i class="bi bi-bar-chart-steps"></i></button>
        <button type="button" class="btn btn-primary" id="function-cleanup" xdisabled data-bs-toggle="tooltip" data-bs-placement="bottom" title="Cleanup code"><i class="bi bi-eyedropper"></i></button>
        <button type="button" class="btn btn-primary" id="function-diff" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Diff"><i class="bi bi-grid-1x2"></i></button>
    </div>
    <div class="w-100">
        <input type="text" id="snippet-title" class="form-control" readonly value="<?= $activeSnippet && isset($activeSnippet['title']) ? htmlspecialchars($activeSnippet['title'] ?? '') : '' ?>" length="255" />
    </div>
</div>
<div class="h-100 border cm-full-height" style="position: relative;">
    <textarea id="formatter-code-input" class="form-control align-self-stretch"><?= $activeSnippet && isset($activeSnippet['snippetLeft']) ? htmlSafeSnippet($activeSnippet['snippetLeft']) : null ?></textarea>
</div>
<div>
    <hr />
    <select id="formatter-code-format" class="form-control">
        <?php foreach ($formats as $format => $name) { ?>
            <?= "<option value=\"{$format}\">{$name}</option>" ?>
        <?php } ?>
    </select>
</div>
<script>
    const activeSnippetFormat = <?= $activeSnippet ? "'{$activeSnippet['format']}'" : 'null' ?>;
</script>
