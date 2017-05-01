<?php
/**
 *
 * Featured Post. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, Spencer Bryson & Lachlan Johnston
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace cssoc\featuredPost\acp;

/**
 * Featured Post ACP module info.
 */
class main_info
{
	public function module()
	{
		return array(
			'filename'	=> '\cssoc\featuredPost\acp\main_module',
			'title'		=> 'ACP_FEATURED_TITLE',
			'modes'		=> array(
				'settings'	=> array(
					'title'	=> 'ACP_FEATURED',
					'auth'	=> 'ext_cssoc/featuredPost && acl_a_board',
					'cat'	=> array('ACP_FEATURED_TITLE')
				),
			),
		);
	}
}
