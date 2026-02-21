<?php

require('_common.php');

function indent_twig($snippet): string
{
    return indent_common($snippet, 'Twig');
}