<?php

require('_common.php');

function indent_php($snippet): string
{
    return indent_common($snippet, 'PHP');
}