<div>
    <div class="btn-group mb-3">
        <!-- <button type="button" class="btn btn-primary" id="function-auto-format" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Auto Format"><i class="bi bi-text-indent-left"></i></button> -->
        <button type="button" class="btn btn-primary" id="function-share" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Share"><i class="bi bi-share"></i></button>
        <button type="button" class="btn btn-primary" id="function-word-wrap" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Word wrap"><i class="bi bi-card-text"></i></button>
    </div>
</div>
<div id="diff-text"></div>
<div>
    <hr />
    <select id="diff-code-format" class="form-control">
        <?php foreach ($formats as $format => $name) { ?>
            <?= "<option value=\"{$format}\">{$name}</option>" ?>
        <?php } ?>
    </select>
</div>
<div id="snippet-left" class="d-none"><?= $activeSnippet ? htmlSafeSnippet($activeSnippet['snippetLeft']) : null ?></div>
<div id="snippet-right" class="d-none"><?= $activeSnippet && !empty($activeSnippet['snippetRight']) ? htmlSafeSnippet($activeSnippet['snippetRight']) : null ?></div>
<script>
    const activeSnippetFormat = <?= $activeSnippet ? "'{$activeSnippet['format']}'" : 'null' ?>;    
</script>