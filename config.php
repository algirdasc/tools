<?php

$title = getenv('APP_TITLE') . ' Tools';

$appBaseUrl = rtrim((string) getenv('APP_BASE_URL'), '/');
$base_url = $appBaseUrl ?: "https://{$_SERVER['SERVER_NAME']}";
$current_url = $base_url . ($_SERVER['REQUEST_URI'] ?? '/');

$tools = [
    'f' => 'formatter',
    'd' => 'diff',
    'h' => 'hashes',
    'm' => 'misc',
];

$js = [
    'formatter' => [
        '//unpkg.com/jsonlint@1.6.3/web/jsonlint.js',
        '/assets/js/addons/selection/active-line.js',
        '/assets/js/addons/selection/mark-selection.js',
        '/assets/js/addons/lint/lint.js',
        '/assets/js/addons/lint/json-lint.js',
        '/assets/js/addons/edit/trailingspace.js',
    ],
    'diff' => [
        '/assets/js/addons/merge/merge.js',
        '/assets/js/diff_match_path.js',
    ],
    'hashes' => [
        '/assets/js/hashing.js',
    ],
];

$formats = [
    'css' => 'CSS',
    'cpp' => 'C++',
    'htmlmixed' => 'HTML',
    'javascript' => 'JavaScript',
    'json' => 'JSON',
    'php' => 'PHP',
    'python' => 'Python',
    'sql' => 'SQL',
    'twig' => 'Twig',
    'yaml' => 'Yaml',
    'text' => 'Text',
    'd' => 'Table',
    'xml' => 'XML',
];
