<?php

require('constants.php');
require('tools/indent/json.php');
require('tools/indent/xml.php');

header('Content-Type: application/json');

$base64 = trim($_POST['base64'] ?? '');

if (!$base64) {
    error('Invalid request');
}

$data = @gzuncompress(hex2bin(str_replace('0x', '', $base64)));

if (!$data) {
    $data = @gzuncompress(base64_decode($base64));
}

if (!$data) {
    error('Failed to uncomporess given string');
}

$format = 'text';
$function = null;
if (strpos($data, '{') === 0) {
    $format = 'JSON';
    $function = 'indent_json';
} elseif (strpos($data, '<') === 0) {
	$format = 'XML';
	$function = 'indent_xml';	
}

if ($function !== null) {
	$data = $function($data, $format);
}
$snippet = saveSnippet($data, null, strtolower($format));

response([
    'redirect' => "{$base_url}/f/{$snippet['hash']}",
    'data' => $data,
]);