<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$config['default_lang'] = 'pt_BR';
$config['lang_avaliable'] = array('en','pt_BR','es'); // See table codes

$config['i18n_path_locales'] = getcwd(). '/locales'; // Where PO files are localized
$config['i18n_domain'] = 'messages'; // Used in gettext
$config['i18n_codeset'] = 'UTF-8';

$config['multilang_map']['controller']['pt_BR'] = array(
	'sitio'	=> 'site',
	'produto' => 'product',
	'empresa' => 'company',
	'usuario' => 'user',
	'login' => 'login'
);
$config['multilang_map']['method']['pt_BR'] = array(
	'sobre' => 'about',
	'quem_somos' => 'about_us',
	'contato'	=> 'contact'
);

$config['multilang_map']['controller']['es'] = array(
	'sitio'	=> 'site',
	'producto' => 'product',
	'empresa' => 'company',
	'usuario' => 'user'
);
$config['multilang_map']['method']['es'] = array(
	'sobre' => 'about',
	'sobre_nosotros' => 'about_us',
	'contacto'	=> 'contact'
);
