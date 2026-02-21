<?php

function indent_json($snippet): string
{
    $decoded = json_decode($snippet);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return $snippet;
    }
    
    return json_encode($decoded, JSON_PRETTY_PRINT | JSON_PRESERVE_ZERO_FRACTION);
}