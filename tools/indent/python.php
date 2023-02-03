<?php

require('_common.php');

function indent_python($snippet): string
{
    return indent_common($snippet, 'Python');
}