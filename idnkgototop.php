<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class IdnkGoToTop extends Module
{
    public function __construct()
    {
        $this->name = 'idnkgototop';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'IDNK Soft';
        $this->need_instance = 0;

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->l('IDNK Go to Top');
        $this->description = $this->l('Adds a link to Go to top of pages.');

        $this->ps_versions_compliancy = ['min' => '1.7.5.0', 'max' => _PS_VERSION_];
    }

    public function createTabs(): void
    {
        $this->deleteTabs();

        // Tab Principal
        if (!Tab::getIdFromClassName('AdminIdnkSoft')) {
            $parent_tab = new Tab();
            $parent_tab->name = [];
            foreach (Language::getLanguages(true) as $lang) {
                $parent_tab->name[$lang['id_lang']] = $this->l('IdnkSoft');
            }

            $parent_tab->class_name = 'AdminIdnkSoft';
            $parent_tab->id_parent = 0;
            $parent_tab->module = $this->name;
            $parent_tab->add();

            $id_full_parent = $parent_tab->id;
        } else {
            $id_full_parent = Tab::getIdFromClassName('AdminIdnkSoft');
        }

        // Tabs
        $parent = new Tab();
        $parent->name = [];
        foreach (Language::getLanguages(true) as $lang) {
            $parent->name[$lang['id_lang']] = $this->l('Go To Top');
        }

        $parent->class_name = 'AdminIdnkGoToTop';
        $parent->id_parent = $id_full_parent;
        $parent->module = $this->name;
        $parent->icon = 'menu';
        $parent->add();

        // Configuración
        $tab_config = new Tab();
        $tab_config->name = [];
        foreach (Language::getLanguages(true) as $lang) {
            $tab_config->name[$lang['id_lang']] = $this->l('Configuration');
        }

        $tab_config->class_name = 'AdminIdnkGoToTopConfig';
        $tab_config->id_parent = $parent->id;
        $tab_config->module = $this->name;
        $tab_config->add();
    }

    public function deleteTabs(): void
    {
        // Tabs
        $idTabs = [];
        $idTabs[] = Tab::getIdFromClassName('AdminIdnkGoToTop');
        $idTabs[] = Tab::getIdFromClassName('AdminIdnkGoToTopConfig');

        foreach ($idTabs as $idTab) {
            if ($idTab) {
                $tab = new Tab($idTab);
                $tab->delete();
            }
        }
    }

    public function install()
    {
        $this->createTabs();

        return parent::install()
            && $this->registerHook('displayHeader')
            && $this->registerHook('displayfooter')
            && $this->setDefaultValues();
    }

    private function setDefaultValues()
    {
        Configuration::updateValue('IDNK_GOTOTOP_FONT_COLOR', '#000000');
        Configuration::updateValue('IDNK_GOTOTOP_BG_COLOR', '#bdbdbd');
        Configuration::updateValue('IDNK_GOTOTOP_FONT_SIZE', '14px');
        Configuration::updateValue('IDNK_GOTOTOP_PADDING', '20px');
        Configuration::updateValue('IDNK_GOTOTOP_BORDER', '1px solid #000');
        Configuration::updateValue('IDNK_GOTOTOP_BORDER_RADIUS', '50%');

        return true;
    }

    public function uninstall()
    {
        $this->deleteTabs();

        return parent::uninstall();
    }

    public function getContent()
    {
        Tools::redirectAdmin($this->context->link->getAdminLink('AdminIdnkGoToTopConfig'));
    }

    public function hookDisplayHeader($params)
    {
        $fontColor = Configuration::get('IDNK_GOTOTOP_FONT_COLOR', '#000000');
        $bgColor = Configuration::get('IDNK_GOTOTOP_BG_COLOR', '#bdbdbd');
        $fontSize = Configuration::get('IDNK_GOTOTOP_FONT_SIZE', '14px');
        $paddingSpace = Configuration::get('IDNK_GOTOTOP_PADDING', '20px');
        $borderColor = Configuration::get('IDNK_GOTOTOP_BORDER', '1px solid #000');
        $borderRadius = Configuration::get('IDNK_GOTOTOP_BORDER_RADIUS', '50%');

        $this->context->smarty->assign(
            [
                'fontColor' => $fontColor,
                'bgColor' => $bgColor,
                'fontSize' => $fontSize,
                'paddingSpace' => $paddingSpace,
                'borderColor' => $borderColor,
                'borderRadius' => $borderRadius,
            ]
        );

        $this->context->controller->addCSS($this->_path . 'views/css/idnkgototop.css');
        $this->context->controller->addJS($this->_path . 'views/js/idnkgototop.js');
    }

    public function hookDisplayFooter($params)
    {
        return $this->display(__FILE__, 'idnkgototop.tpl');
    }
}
