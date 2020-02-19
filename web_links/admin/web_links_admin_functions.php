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

// save time, move to class complicates things 

function LinksLinkCheck() {
    $caption = _VALIDATELINKS;
    $text = 'Comming soon';
    e107::getRender()->tablerender($caption, $text, 'web_links_index');
}

function LinksCleanVotes() {
    $caption = _CLEANLINKSDB;
    $text = 'Comming soon';
    e107::getRender()->tablerender($caption, $text, 'web_links_index');
}

function LinksListBrokenLinks() {
    $caption = _BROKENLINKS;
    $text = 'Comming soon';
    e107::getRender()->tablerender($caption, $text, 'web_links_index');
}

function LinksListModRequests() {
    $caption = _MODREQLINKS;
    $text = 'Comming soon';
    e107::getRender()->tablerender($caption, $text, 'web_links_index');
}

function Links() {
    $caption = _WLINKS;
    $text = 'Comming soon';
    e107::getRender()->tablerender($caption, $text, 'web_links_index');
}

