<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Router extends CI_Router
{
	var $controller = '';
	var $method = '';
	
	function __construct()
	{
		parent::__construct();
		$this->_map = config_item('multilang_map');
		$this->lang = config_item('lang');
		$this->lang_avaliable = config_item('lang_avaliable');
	}
	
	
	/*
	 * $lang - (en,pt_BR,fr,it,...)
	 */
	private function get_segment_by_lang()
	{
		$count = count($this->uri->segments);

		if($count > 0)
		{
			$lang = $this->uri->segments[0];

			// exist lang into map
			if(isset($this->_map['controller'][$lang]))
			{
				if($count == 1)
				{
					$this->controller = 'site';
					$this->method = 'index';
					return true;
				}
				elseif($count == 2)
				{
					$this->controller = 'site';
					if(isset($this->_map['method'][$lang][$this->uri->segments[1]]))
					{
						$this->method = $this->_map['method'][$lang][$this->uri->segments[1]];
						return true;
					}
					$this->method = 'index';
					return $this->_set_controller();
				}
				else
				{
					
					if(isset($this->_map['controller'][$lang][$this->uri->segments[1]]))
					{
						$this->controller = $this->_map['controller'][$lang][$this->uri->segments[1]];
	
						if(isset($this->_map['method'][$lang][$this->uri->segments[2]]))
						{
							$this->method = $this->_map['method'][$lang][$this->uri->segments[2]];
							return true;
						}
					}
					$this->method = 'index';
					return true;
				}
				return $this->_set_controller();
			}
			else
			{
				if($this->uri->segments[0] == 'en')
				{
					if($count == 1)
					{
						$this->controller = 'site';
						$this->method = 'index';
						return true;
					}
					elseif($count == 2)
					{
						$this->controller = 'site';
						$this->method = $this->uri->segments[1];
						return true;
					}
					else
					{
						$this->controller = $this->uri->segments[1];
						$this->method = $this->uri->segments[2];
						return true;
					}
				}
				if($count > 1)
				{
					return $this->_set_controller();
				}
				
			}

		}
		return false;
	}

	/**
	 * 
	 *
	 * @access private
	 * @return boolean
	 */
	private function _set_controller()
	{
		if(file_exists(APPPATH . 'controllers/' . $this->uri->segments[1] . '.php'))
		{
			$this->controller = $this->uri->segments[1];

			if(!isset($this->uri->segments[2]))
				$this->method = 'index';
			else
				$this->method = $this->uri->segments[2];
			return true;
		}
		return false;
	}

	/**
	 * Validates the supplied segments.  Attempts to determine the path to
	 * the controller.
	 *
	 * @access private
	 * @param array $
	 * @return array
	 */
	function _validate_request($segments)
	{
		if(count($segments) == 0)
		{
			return $segments;
		}

		// now compare $segments[0] with $config['multilang_map']
		if($this->get_segment_by_lang())
		{
			$segments[0] = $this->controller;
			$segments[1] = $this->method;
			$this->default_controller = $segments[0];
		}

		// Does the requested controller exist in the root folder?
		if(file_exists(APPPATH . 'controllers/' . $segments[0] . '.php'))
		{
			return $segments;
		}

		// If we've gotten this far it means that the URI does not correlate to a valid
		// controller class.  We will now see if there is an override
		if(!empty($this->routes['404_override']))
		{
			$x = explode('/', $this->routes['404_override']);

			$this->set_class($x[0]);
			$this->set_method(isset($x[1]) ? $x[1] : 'index');

			return $x;
		}
		// Nothing else to do at this point but show a 404
		show_404($segments[0]);
	}

	/**
	 * Set the Route
	 *
	 * This function takes an array of URI segments as
	 * input, and sets the current class/method
	 *
	 * @access	private
	 * @param	array
	 * @param	bool
	 * @return	void
	 */
	function _set_request($segments = array())
	{
		$segments = $this->_validate_request($segments);

		if(count($segments) == 0)
		{
			return $this->_set_default_controller();
		}

		$this->set_class($segments[0]);

		if(isset($segments[1]))
		{
			// A standard method request
			$this->set_method($segments[1]);
		}
		else
		{
			// This lets the "routed" segment array identify that the default
			// index method is being used.
			$segments[1] = 'index';
		}

		// Update our "routed" segment array to contain the segments.
		// Note: If there is no custom routing, this array will be
		// identical to $this->uri->segments
		$this->uri->rsegments = $segments;
	}

}
?>