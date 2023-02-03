<?php

require('_common.php');

function indent_htmlmixed($snippet): string
{
   return indent_common($snippet, 'HTML');
}