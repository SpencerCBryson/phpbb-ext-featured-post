<?php
/**
 *
 * Featured Post. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, Spencer Bryson & Lachlan Johnston
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace cssoc\featuredPost\migrations;

class install_acp_module extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['f_enabled']);
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v31x\v314');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('f_widget_title', 'Featured Post')),
			array('config.add', array('f_img_width', '256px')),
			array('config.add', array('f_img_radius', '50%')),
			array('config.add', array('f_num_lines', '4')),
			array('config.add', array('f_btn_text', 'View full post')),
			array('config.add', array('f_img', '')),
			array('config.add', array('f_post_id', '')),
			array('config.add', array('f_guests', '1')),
			array('config.add', array('f_enabled', '1')),
			array('config.add', array('f_hide_date', '0')),
			array('config.add', array('f_bbcode', '1')),

			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_FEATURED_TITLE'
			)),
			array('module.add', array(
				'acp',
				'ACP_FEATURED_TITLE',
				array(
					'module_basename'	=> '\cssoc\featuredPost\acp\main_module',
					'modes'				=> array('settings'),
				),
			)),
		);
	}
}
