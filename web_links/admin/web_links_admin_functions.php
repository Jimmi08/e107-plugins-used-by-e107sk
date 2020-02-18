<?php

if (!defined('e107_INIT'))
{
	exit;
}


function OpenTable() {
 
    $text = '<table><tbody>';
    return $text;
}

function CloseTable() {
 
    $text = '</tbody></table>';
    return $text;
}