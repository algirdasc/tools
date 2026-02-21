<?php

require('_common.php');

function indent_sql($snippet): string
{
    return indent_common($snippet, 'SQL');
}