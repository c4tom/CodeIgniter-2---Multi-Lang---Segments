<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// ------------------------------------------------------------------------

/**
 * CodeIgniter Multilangsegments Hooks
 *
 * @package		CodeIgniter
 * @subpackage	Hooks
 * @category	Hooks
 * @author		Candido H. Tominaga
 * @link		https://github.com/candido1212/CodeIgniter-Multi-Lang-Segments
 */

// ------------------------------------------------------------------------

/**
 * Multilangsegments
 *
 * Hook for multi lang idiom application with CodeIgniter.
 *
 */
 class Multilangsegments
 {
 	// ------------------------------------------------------------------------
 	
 	/**
	 * Constructor
	 *
	 * The constructor can be passed an array of config values
	 */
	public function __construct()
	{
		// Load the multilingual.php config file.
		require APPPATH.'config/multilangsegments.php';
		$this->conf = $config;
	}
 	
	// ------------------------------------------------------------------------
	
	/**
	 * Get Language
	 *
	 * Get current language,
	 * using browser preferences, first, then URL
	 *
	 * @access	private
	 * @param	none
	 * @return	string
	 */
	private function _get_language()
	{
		// Detect URI Lang, if cannot find, then return Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']), this require  PHP 5.3.x or >

		preg_match('#^/([a-z]{2}[A-Z_]{0,3})#', str_replace(dirname($_SERVER['SCRIPT_NAME']),'', $_SERVER['REQUEST_URI']), $_match);
		
		if(isset($_match[1]))
		{
			// if into avaliable array lang?
			locale_set_default($_match[1]);
			return $_match[1];
		}	
		else
		{
			return Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
		}	
	}
	
	
	// ------------------------------------------------------------------------

	/**
	 * Language conf
	 *
	 * Put the correct language
	 * in the config.php config file.
	 *
	 * @access	public
	 * @param	none
	 * @return	void
	 */
	public function set_language()
	{
		// Get config instance
		$this->config =& load_class('Config');
		// Change the language of the configuration by the current language found with the hook
		$lang = $this->_get_language();
		$this->config->set_item('lang', $lang);
		
		if(!array_search($lang, $this->conf['lang_avaliable']) and $lang != 'en')
		{
			show_404();
		}
		$this->config->set_item('multilang_map', $this->conf['multilang_map']);
		$this->config->set_item('lang_avaliable', $this->conf['lang_avaliable']);
		$this->config->set_item('lang_re', implode('|',$this->conf['lang_avaliable']));
	
		setlocale(LC_ALL, $lang);
		putenv("LANG=$lang");
		putenv("LANGUAGE=$lang");
		
		bindtextdomain($this->conf['i18n_domain'], $this->conf['i18n_path_locales']);
		bind_textdomain_codeset($this->conf['i18n_domain'], $this->conf['i18n_codeset']); 
		textdomain($this->conf['i18n_domain']);
		//http://www.gnu.org/software/gettext/manual/gettext.html#Concepts
	}
}

?>