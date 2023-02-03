<?php

require('constants.php');

header('Content-Type: application/json');

$snippetLeft = $_POST['left'] ?? '';
$snippetRight = $_POST['right'] ?? '';
$format = trim($_POST['format'] ?? '');
$title = trim($_POST['title'] ?? '');

if (!$snippetLeft || !$format || !array_key_exists($format, $formats)) {
    error('Invalid request');
}

if ($snippet = saveSnippet($snippetLeft, $snippetRight, $format, $title)) {
    response(['hash' => $snippet['hash']]);
}

error('Snippet not found!');