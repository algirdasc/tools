<?php

require('_common.php');

function indent_xml($snippet): string
{
	try {
		$doc = new DOMDocument('1.0');
		$doc->preserveWhiteSpace = false;
		$doc->formatOutput = true;
		$doc->loadXML($snippet);
		$snippet = $doc->saveXML();
	} catch (Exception $ex) {
	}
	
	return $snippet;
}