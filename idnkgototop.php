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

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->l('IDNK Go to Top');
        $this->description = $this->l('Adds a link to Go to top of pages.');

        $this->ps_versions_compliancy = ['min' => '1.7.5.0', 'max' => _PS_VERSION_];

    }
 
	public function install()
	{
        Configuration::updateValue('IDNK_GOTOTOP_FONT_COLOR', '#ffffff');
        Configuration::updateValue('IDNK_GOTOTOP_BG_COLOR', '#181818');
        Configuration::updateValue('IDNK_GOTOTOP_FONT_SIZE', '3rem');
        Configuration::updateValue('IDNK_GOTOTOP_PADDING', '1rem');
        Configuration::updateValue('IDNK_GOTOTOP_BORDER', '1px solid');
        Configuration::updateValue('IDNK_GOTOTOP_BORDERRADIUS', '100vmax');
        Configuration::updateValue('IDNK_GOTOTOP_HOVEREFFECT', '');

        return parent::install()
            && $this->registerHook('displayHeader')
            && $this->registerHook('displayfooter');

	}
	
    public function uninstall()
    {
        return parent::uninstall();

    }

    public function getContent()
    {
        $output = null;

        if (Tools::isSubmit('submit'.$this->name))
        {
            $fontColor = (string)Tools::getValue('IDNK_GOTOTOP_FONT_COLOR');
            $bgColor = (string)Tools::getValue('IDNK_GOTOTOP_BG_COLOR');
            $fontSize = (string)Tools::getValue('IDNK_GOTOTOP_FONT_SIZE');
            $paddingSpace = (string)Tools::getValue('IDNK_GOTOTOP_PADDING');
            $borderStyle = (string)Tools::getValue('IDNK_GOTOTOP_BORDER');
            $borderRadius = (string)Tools::getValue('IDNK_GOTOTOP_BORDERRADIUS');
            $hoverEffect = (string)Tools::getValue('IDNK_GOTOTOP_HOVEREFFECT');

            Configuration::updateValue('IDNK_GOTOTOP_FONT_COLOR', $fontColor);
            Configuration::updateValue('IDNK_GOTOTOP_BG_COLOR', $bgColor);
            Configuration::updateValue('IDNK_GOTOTOP_FONT_SIZE', $fontSize);
            Configuration::updateValue('IDNK_GOTOTOP_PADDING', $paddingSpace);
            Configuration::updateValue('IDNK_GOTOTOP_BORDER', $borderStyle);
            Configuration::updateValue('IDNK_GOTOTOP_BORDERRADIUS', $borderRadius);
            Configuration::updateValue('IDNK_GOTOTOP_HOVEREFFECT', $hoverEffect);

            $output .= $this->displayConfirmation($this->trans('Settings updated', array(), 'Admin.IdnkGoToTop.Success'));
        }

        return $output.$this->displayForm();
    }

    public function displayForm()
    {
        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

        $fields_form[0]['form'] = [
            'legend' => [
                'title' => $this->trans('Settings', [], 'Admin.Global'),
            ],
            'input' => [
                [
                    'type' => 'color',
                    'label' => $this->trans('Font Color', [], 'Modules.IdnkGoToTop.Admin'),
                    'name' => 'IDNK_GOTOTOP_FONT_COLOR',
                    'desc' => $this->trans('Select font color for the arrow.', [], 'Modules.IdnkGoToTop.Admin'),
                    'required' => true
                ],
                [
                    'type' => 'color',
                    'label' => $this->trans('Background Color', [], 'Modules.IdnkGoToTop.Admin'),
                    'name' => 'IDNK_GOTOTOP_BG_COLOR',
                    'desc' => $this->trans('Select background color for the arrow.', [], 'Modules.IdnkGoToTop.Admin'),
                    'required' => true
                ],
                [
                    'type' => 'text',
                    'label' => $this->trans('Font size', [], 'Modules.IdnkGoToTop.Admin'),
                    'name' => 'IDNK_GOTOTOP_FONT_SIZE',
                    'desc' => $this->trans('Put size for font: 18px, 1.5rem.', [], 'Modules.IdnkGoToTop.Admin'),
                    'size' => 20,
                    'col' => '4',
                    'required' => false
                ],
                [
                    'type' => 'text',
                    'label' => $this->trans('Padding space', [], 'Modules.IdnkGoToTop.Admin'),
                    'name' => 'IDNK_GOTOTOP_PADDING',
                    'desc' => $this->trans('Put padding for space: 8px, 0.5rem.', [], 'Modules.IdnkGoToTop.Admin'),
                    'size' => 10,
                    'col' => '4',
                    'required' => false
                ],
                [
                    'type' => 'text',
                    'label' => $this->trans('Border Asign', [], 'Modules.IdnkGoToTop.Admin'),
                    'name' => 'IDNK_GOTOTOP_BORDER',
                    'desc' => $this->trans('Put values for border: 1ps solid #181818.', [], 'Modules.IdnkGoToTop.Admin'),
                    'maxlength' => 200,
                    'col' => '4',
                    'required' => false
                ],
                [
                    'type' => 'text',
                    'label' => $this->trans('Border Radius', [], 'Modules.IdnkGoToTop.Admin'),
                    'name' => 'IDNK_GOTOTOP_BORDERRADIUS',
                    'desc' => $this->trans('Put values for border radius: 100vmax, 50%, 10px.', [], 'Modules.IdnkGoToTop.Admin'),
                    'maxlength' => 200,
                    'col' => '4',
                    'required' => false
                ],
                [
                    'type' => 'text',
                    'label' => $this->trans('Hover Effect', [], 'Modules.IdnkGoToTop.Admin'),
                    'name' => 'IDNK_GOTOTOP_HOVEREFFECT',
                    'desc' => $this->trans('Put values for hover effect: filter: hue-rotate(90deg), filter: opacity(0.5).', [], 'Modules.IdnkGoToTop.Admin'),
                    'maxlength' => 200,
                    'col' => '4',
                    'required' => false
                ],
            ],
            'submit' => [
                'title' => $this->trans('Save', [], 'Admin.Actions'),
                'class' => 'btn btn-default pull-right'
            ]
        ];

        $helper = new HelperForm();

        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;

        $helper->default_form_language = $default_lang;
        $helper->allow_employee_form_lang = $default_lang;

        $helper->title = $this->displayName;
        $helper->show_toolbar = true;        // false -> remove toolbar
        $helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
        $helper->submit_action = 'submit'.$this->name;
        $helper->toolbar_btn = [
            'save' =>
                [
                    'desc' => $this->trans('Save', [], 'Admin.Actions'),
                    'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
                        '&token='.Tools::getAdminTokenLite('AdminModules'),
                ],
            'back' => [
                'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->trans('Back to list', [], 'Admin.Actions')
            ]
        ];

        $helper->fields_value['IDNK_GOTOTOP_FONT_COLOR'] = Configuration::get('IDNK_GOTOTOP_FONT_COLOR');
        $helper->fields_value['IDNK_GOTOTOP_BG_COLOR'] = Configuration::get('IDNK_GOTOTOP_BG_COLOR');
        $helper->fields_value['IDNK_GOTOTOP_FONT_SIZE'] = Configuration::get('IDNK_GOTOTOP_FONT_SIZE');
        $helper->fields_value['IDNK_GOTOTOP_PADDING'] = Configuration::get('IDNK_GOTOTOP_PADDING');
        $helper->fields_value['IDNK_GOTOTOP_BORDER'] = Configuration::get('IDNK_GOTOTOP_BORDER');
        $helper->fields_value['IDNK_GOTOTOP_BORDERRADIUS'] = Configuration::get('IDNK_GOTOTOP_BORDERRADIUS');
        $helper->fields_value['IDNK_GOTOTOP_HOVEREFFECT'] = Configuration::get('IDNK_GOTOTOP_HOVEREFFECT');

        return $helper->generateForm($fields_form);
    }

    public function hookDisplayHeader($params)
    {
        $fontColor = Configuration::get('IDNK_GOTOTOP_FONT_COLOR', '#ffffff');
        $bgColor = Configuration::get('IDNK_GOTOTOP_BG_COLOR', '#181818');
        $fontSize = Configuration::get('IDNK_GOTOTOP_FONT_SIZE', '3rem');
        $paddingSpace = Configuration::get('IDNK_GOTOTOP_PADDING', '1rem');
        $borderStyle = Configuration::get('IDNK_GOTOTOP_BORDER', '1px solid #fff');
        $borderRadius = Configuration::get('IDNK_GOTOTOP_BORDERRADIUS', '100vmax');
        $hoverEffect = Configuration::get('IDNK_GOTOTOP_HOVEREFFECT', '');

        $this->context->smarty->assign(
            [
                'fontColor' => $fontColor,
                'bgColor' => $bgColor,
                'fontSize' => $fontSize,
                'paddingSpace' => $paddingSpace,
                'borderStyle' => $borderStyle,
                'borderRadius' => $borderRadius,
                'hoverEffect' => $hoverEffect
            ]
        );

        $this->context->controller->addCSS($this->_path.'views/css/idnkgototop.css');
        $this->context->controller->addJS($this->_path.'views/js/idnkgototop.js');
    }
	
	public function hookDisplayFooter($params)
	{
	  return $this->display(__FILE__, 'idnkgototop.tpl');
	}
	
}
