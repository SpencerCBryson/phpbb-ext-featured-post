<?php
/**
 *
 * Featured Post. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, Spencer Bryson & Lachlan Johnston
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace cssoc\featuredPost\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Featured Post Event listener.
 */
class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.index_modify_page_title'	=> 'add_featured_post',
		);
	}


	/* @var \phpbb\config\config */
	protected $config;

	/* @var \phpbb\template\template */
	protected $template;

	/* @var \phpbb\user */
	protected $user;

	/** @var string phpEx */
	protected $php_ext;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;



	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config		$config		Config object
	 * @param \phpbb\template\template	$template	Template object
	 * @param \phpbb\user               $user       User object
	 * @param \phpbb\db\driver\driver_interface $db
	 * @param string                    $php_ext    phpEx
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\template\template $template, \phpbb\user $user, \phpbb\db\driver\driver_interface $db, $root_path, $php_ext)
	{
		$this->config   = $config;
		$this->template = $template;
		$this->user     = $user;
		$this->db		= $db;
		$this->root_path= $root_path;
		$this->php_ext  = $php_ext;
	}


	public function add_featured_post($event)
	{
		if(strlen($this->config['f_post_id']) != 0) { // post id field not empty
			//get post info
			$f_post_id = $this->config['f_post_id'];

			$sql = 'SELECT *
					FROM ' . POSTS_TABLE . '
					WHERE post_id = ' . $f_post_id;

			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			$f_forum_id = $row['forum_id'];
			$f_topic_id = $row['topic_id'];


			$row['bbcode_options'] = (($row['enable_bbcode']) ? OPTION_FLAG_BBCODE : 0) +
				(($row['enable_smilies']) ? OPTION_FLAG_SMILIES : 0) +
				(($row['enable_magic_url']) ? OPTION_FLAG_LINKS : 0);

			if($this->config['f_bbcode']) {
				$f_post_text = generate_text_for_display($row['post_text'], $row['bbcode_uid'], $row['bbcode_bitfield'], $row['bbcode_options']);
			} else {
				$f_post_text = $row['post_text'];
			}

			//get username
			$user_id = $row['poster_id'];
			$sql = 'SELECT *
					FROM ' . USERS_TABLE . '
					WHERE user_id = ' . $user_id;


			$result = $this->db->sql_query($sql);
			$u_row = $this->db->sql_fetchrow($result);

			$this->template->assign_vars(array(
				'F_WIDGET_TITLE'	=> $this->config['f_widget_title'],
				'F_POST_TITLE'		=> $row['post_subject'],
				'F_POST_TEXT'		=> $f_post_text,
				'F_POST_LINK'		=> append_sid("{$this->root_path}viewtopic.$this->php_ext", "f=$f_forum_id&amp;t=$f_topic_id&amp;p=$f_post_id#p$f_post_id"),
				'F_IMG'				=> $this->config['f_img'],
				'F_IMG_WIDTH'		=> $this->config['f_img_width'],
				'F_IMG_RADIUS'		=> $this->config['f_img_radius'],
				'F_NUM_LINES'		=> $this->config['f_num_lines'],
				'F_LINE_HEIGHT' 	=> 16 * $this->config['f_num_lines'],
				'F_POST_TIME'		=> $this->user->format_date($row['post_time']),
				'F_AUTHOR'			=> get_username_string('full', $user_id, $u_row['username'], $u_row['user_colour']),
				'F_GUESTS'			=> $this->config['f_guests'],
				'F_ENABLED'			=> $this->config['f_enabled'],
				'F_HIDE_DATE'		=> $this->config['f_hide_date'],
				'F_BTN_TEXT'		=> $this->config['f_btn_text']
			));


		// post id is empty
		} else {
			$this->template->assign_vars(array(
				'F_ENABLED'			=> 0
			));
		}


	}
}
