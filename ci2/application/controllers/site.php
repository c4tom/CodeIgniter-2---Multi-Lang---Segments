<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		if(count($this->uri->segments) == 0)
		{
			header('Location: '.$this->config->config['base_url'] . config_item('lang'));
		}
		echo __('Index') . other_langs();
		
		//$this->output->enable_profiler(TRUE);
	}

	public function contact()
	{
		echo __('Contact') . other_langs();
	}
	
	function about()
	{
		echo __('About') . other_langs();
	}
	
	function about_us()
	{
		echo __('About Us') . other_langs();
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/site.php */