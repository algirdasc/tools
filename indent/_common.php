<?php

function indent_common(string $snippet, string $format): string
{
    $context  = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header'  => 'Content-Type: application/x-www-form-urlencoded',
            'content' => http_build_query(['snippet' => $snippet, 'format' => $format]),
        ]
    ]);

    if ($return = file_get_contents('http://puga.lan/tools/beautify', false, $context)) {
        $return = trim($return);
        if ($return === '') {
            $return = null;
        }
    }

    return $return ?? $snippet;
}