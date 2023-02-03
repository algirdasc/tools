<?php require('constants.php') ?>

<!doctype html>

<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:title" content="<?= $title ?>">
    <meta property="og:url" content="https://tools.cici.lt/">
    <meta property="og:type" content="website">
    <meta property="og:description" content="Developer pastebin & tools">
    <meta property="og:image" content="https://tools.cici.lt/assets/img/cloud-logo-black.png">    

    <link rel="manifest" href="/site.webmanifest">
    <link rel="apple-touch-icon" href="icon.png">

    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/css/theme.css" rel="stylesheet">
    <link href="/assets/css/codemirror.css" rel="stylesheet">
    <link href="/assets/css/theme/idea.css" rel="stylesheet">
    <link href="/assets/css/addon/dialog/dialog.css" rel="stylesheet">
    <link href="/assets/css/addon/fold/foldgutter.css" rel="stylesheet">
    <link href="/assets/css/addon/lint/lint.css" rel="stylesheet">
    <link href="/assets/css/addon/merge/merge.css" rel="stylesheet">
</head>

<body>
    <main>
        <div class="d-flex flex-column flex-shrink-0 bg-light" style="width: 4.5rem;">
            <a href="/" class="d-block p-3 link-dark text-decoration-none border-bottom">
                <img src="/assets/img/cloud-logo-black.png" class="img-fluid" />
            </a>
            <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
                <li class="nav-item">
                    <a href="/f" class="nav-link <?= $activeTool === 'formatter' ? 'active' : null ?> py-3 border-bottom" data-bs-toggle="tooltip" data-bs-placement="right" title="Code">
                        <i class="bi bi-code-slash"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/d" class="nav-link <?= $activeTool === 'diff' ? 'active' : null ?> py-3 border-bottom" data-bs-toggle="tooltip" data-bs-placement="right" title="Diff">
                        <i class="bi bi-grid-1x2"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/h" class="nav-link <?= $activeTool === 'hashes' ? 'active' : null ?> py-3 border-bottom" data-bs-toggle="tooltip" data-bs-placement="right" title="Hashes">
                        <i class="bi bi-funnel"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/m" class="nav-link <?= $activeTool === 'misc' ? 'active' : null ?> py-3 border-bottom" data-bs-toggle="tooltip" data-bs-placement="right" title="Misc">
                        <i class="bi bi-hammer"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="bg p-3">
            <div class="row h-100">
                <div class="col-12">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex flex-column h-100">
                                <?php require('tools/' . $activeTool . '.php') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php require('toast.php') ?>
</body>
<script src="/assets/js/zepto.min.js"></script>
<script src="/assets/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/moment.min.js"></script>
<script src="/assets/js/moment-timezone.min.js"></script>
<script src="/assets/js/helpers.js"></script>
<script src="/assets/js/codemirror.js"></script>
<script src="/assets/js/mode/meta.js"></script>
<script src="/assets/js/addons/dialog/dialog.js"></script>
<script src="/assets/js/addons/edit/matchbrackets.js"></script>
<script src="/assets/js/addons/edit/matchtags.js"></script>
<script src="/assets/js/addons/fold/foldcode.js"></script>
<script src="/assets/js/addons/fold/foldgutter.js"></script>
<script src="/assets/js/addons/fold/brace-fold.js"></script>
<script src="/assets/js/addons/fold/xml-fold.js"></script>
<script src="/assets/js/addons/fold/indent-fold.js"></script>
<script src="/assets/js/addons/fold/markdown-fold.js"></script>
<script src="/assets/js/addons/fold/comment-fold.js"></script>
<script src="/assets/js/addons/mode/loadmode.js"></script>
<script src="/assets/js/addons/search/searchcursor.js"></script>
<script src="/assets/js/addons/search/search.js"></script>
<?php foreach ($js[$activeTool] ?? [] as $js) { ?>
    <script src="<?= $js ?>"></script>
<?php } ?>
<script src="/assets/js/tools/common.pre.js"></script>
<script src="/assets/js/tools/<?= $activeTool ?>.js"></script>
<script src="/assets/js/tools/common.post.js"></script>
</html>