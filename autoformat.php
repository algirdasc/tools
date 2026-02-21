<?php

require('config.php');
require('lib.php');

header('Content-Type: application/json');

$snippet = trim($_POST['snippet']) ?? '';
$format = trim($_POST['format']) ?? null;

if (!$snippet || !$format) {
    error('Invalid request');
}

if (file_exists("tools/indent/{$format}.php")) {
    require("tools/indent/{$format}.php");
    $fn = "indent_{$format}";
    if (function_exists($fn)) {
        response(['snippet' => $fn($snippet)]);
    } else {
        error('No indent function found');
    }
}

error('No indent file found');
