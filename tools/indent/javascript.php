<?php

require('_common.php');

function indent_javascript($snippet): string
{
    $decoded = json_decode($snippet);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return indent_common($snippet, 'JavaScript');
    }
    
    return json_encode($decoded, JSON_PRETTY_PRINT | JSON_PRESERVE_ZERO_FRACTION);
}