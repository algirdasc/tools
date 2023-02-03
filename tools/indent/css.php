<?php

require('_common.php');

function indent_css($snippet): string
{
   return indent_common($snippet, 'CSS');
}