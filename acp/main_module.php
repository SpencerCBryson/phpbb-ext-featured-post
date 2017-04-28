<?php
/**
 *
 * Featured Post. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, Spencer Bryson & Lachlan Jonston
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace cssoc\featuredPost\acp;

/**
 * Featured Post ACP module.
 */
class main_module
{
	public $page_title;
	public $tpl_name;
	public $u_action;

	public function main($id, $mode)
	{
		global $config, $request, $template, $user;

		$user->add_lang_ext('cssoc/featuredPost', 'common');
		$this->tpl_name = 'acp_featured_body';
		$this->page_title = $user->lang('ACP_FEATURED_TITLE');
		add_form_key('cssoc/featuredPost');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('cssoc/featuredPost'))
			{
				trigger_error('FORM_INVALID');
			}

			$config->set('f_widget_title', $request->variable('f_widget_title', '', true));
			$config->set('f_post_id', $request->variable('f_post_id', '', true));
			$config->set('f_img', $request->variable('f_img', '', true));
			$config->set('f_img_width', $request->variable('f_img_width', '', true));
			$config->set('f_img_radius', $request->variable('f_img_radius', '', true));
			$config->set('f_num_lines', $request->variable('f_num_lines', '', true));
			$config->set('f_btn_text', $request->variable('f_btn_text', '', true));
			$config->set('f_guests', $request->variable('f_guests', 1));
			$config->set('f_enabled', $request->variable('f_enabled', 1));
			$config->set('f_hide_date', $request->variable('f_hide_date', 0));
			
			
			trigger_error($user->lang('ACP_FEATURED_SETTING_SAVED') . adm_back_link($this->u_action));
		}
		
		$f_widget_title = $config['f_widget_title'];
		$f_post_id = $config['f_post_id'];
		$f_img = $config['f_img'];
		$f_img_width = $config['f_img_width'];
		$f_img_radius = $config['f_img_radius'];
		$f_num_lines = $config['f_num_lines'];
		$f_guests = $config['f_guests'];
		$f_enabled = $config['f_enabled'];
		$f_hide_date = $config['f_hide_date'];
		$f_btn_text = $config['f_btn_text'];

		$template->assign_vars(array(
			'U_ACTION'				=> $this->u_action,
			'F_WIDGET_TITLE'		=> $f_widget_title,
			'F_POST_ID'				=> $f_post_id,
			'F_IMG'					=> $f_img,
			'F_IMG_WIDTH'			=> $f_img_width,
			'F_IMG_RADIUS'			=> $f_img_radius,
			'F_NUM_LINES'			=> $f_num_lines,
			'F_GUESTS'				=> $f_guests,
			'F_ENABLED'				=> $f_enabled,
			'F_HIDE_DATE'			=> $f_hide_date,
			'F_BTN_TEXT'			=> $f_btn_text
		));
	}
}
