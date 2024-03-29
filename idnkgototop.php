<?php

if (!defined('_PS_VERSION_'))
  exit;
 
class IdnkGoToTop extends Module
{
  public function __construct()
  {
    $this->name = 'idnkgototop';
    $this->tab = 'front_office_features';
    $this->version = 1.0;
    $this->author = 'IDNK Soft';
    $this->need_instance = 0;
 
    parent::__construct();
 
    $this->displayName = $this->l('IDNK Go to Top');
    $this->description = $this->l('Adds a link to Go to top of pages.');
  }
 
	public function install()
	{

        return parent::install()
            && $this->registerHook('displayHeader')
            && $this->registerHook('displayfooter');

	}
	
    public function uninstall()
    {
        return parent::uninstall();

    }


	public function hookDisplayHeader($params)
	{
			$this->context->controller->addCSS($this->_path.'views/css/idnkgototop.css');
			$this->context->controller->addJS($this->_path.'views/js/idnkgototop.js');
			return;
	}
	
	public function hookDisplayFooter($params)
	{
	  return $this->display(__FILE__, 'idnkgototop.tpl');
	}
	
}
