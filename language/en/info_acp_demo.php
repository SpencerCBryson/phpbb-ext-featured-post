<?php
/**
 *
 * Featured Post. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, Lachlan Jonston
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_FEATURED_TITLE'			=> 'Featured Post',
	'ACP_FEATURED'					=> 'Settings',
	'ACP_FEATURED_SETTING_SAVED'	=> 'Settings have been saved successfully!'
));
