<?php

require('config.php');
require('lib.php');

header('Content-Type: application/json');

$snippetLeft = $_POST['left'] ?? '';
$snippetRight = $_POST['right'] ?? '';
$format = trim($_POST['format'] ?? '');
$title = trim($_POST['title'] ?? '');

if (!$snippetLeft || !$format || !array_key_exists($format, $formats)) {
    error('Invalid request');
}

if ($snippet = saveSnippet($format, $snippetLeft, $snippetRight, $title)) {
    response(['hash' => $snippet['hash']]);
}

error('Snippet not found!');