<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {

	public function index()
	{
		echo 'produtc' . change_lang_to('pt_BR',1);
	}
	
	function test()
	{
		echo 'test' . change_lang_to('pt_BR',1);
	}
	
	function manage()
	{
		echo __('manage');
	}
	
}

/* End of file product.php */
/* Location: ./application/controllers/product.php */