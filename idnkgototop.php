<?php

if (!defined('_PS_VERSION_'))
    exit;

class IdnkGoToTop extends Module
{
    public function __construct()
    {
        $this->name = 'idnkgototop';
        $this->author = 'IDNK Soft';
        $this->version = '1.1.0';
        $this->tab = 'front_office_features';
        $this->need_instance = 0;

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->trans('IDNK Go to Top', array(), 'Modules.IdnkGoToTop.Admin');
        $this->description = $this->trans('Adds a link to Go to top of pages.', array(), 'Modules.IdnkGoToTop.Admin');

        $this->ps_versions_compliancy = ['min' => '1.7.5.0', 'max' => _PS_VERSION_];
    }

    public function createTabs(): void
    {
        // Eliminar tabs antiguos
        $this->deleteTabs();

        // Tab Principal
        if (!Tab::getIdFromClassName('AdminIdnkSoft')) {
            $parent_tab = new Tab();
            $parent_tab->name = [];
            foreach (Language::getLanguages(true) as $lang) {
                $parent_tab->name[$lang['id_lang']] = $this->trans('IdnkSoft');
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
            $parent->name[$lang['id_lang']] = $this->trans('Go To Top');
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
            $tab_config->name[$lang['id_lang']] = $this->trans('Configuración');
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
        Configuration::updateValue('IDNK_GOTOTOP_DESIGN', 'style10');
        Configuration::updateValue('IDNK_GOTOTOP_FONT_COLOR', '#000000');
        Configuration::updateValue('IDNK_GOTOTOP_BG_COLOR', '#c7c7c7');
        Configuration::updateValue('IDNK_GOTOTOP_FONT_SIZE', '24px');
        Configuration::updateValue('IDNK_GOTOTOP_PADDING', '15px');
        Configuration::updateValue('IDNK_GOTOTOP_BORDER', 'none');
        Configuration::updateValue('IDNK_GOTOTOP_BORDER_RADIUS', '50%');
        Configuration::updateValue('IDNK_GOTOTOP_PULSE_COLOR', '#bbbbbb');
        Configuration::updateValue('IDNK_GOTOTOP_PULSE_COLOR_TRANS', '#74747400');
        Configuration::updateValue('IDNK_GOTOTOP_PULSE_SIZE', '55px');

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
        $effectStyle = Configuration::get('IDNK_GOTOTOP_DESIGN');
        $fontColor = Configuration::get('IDNK_GOTOTOP_FONT_COLOR');
        $bgColor = Configuration::get('IDNK_GOTOTOP_BG_COLOR');
        $fontSize = Configuration::get('IDNK_GOTOTOP_FONT_SIZE');
        $paddingSpace = Configuration::get('IDNK_GOTOTOP_PADDING');
        $borderColor = Configuration::get('IDNK_GOTOTOP_BORDER');
        $borderRadius = Configuration::get('IDNK_GOTOTOP_BORDER_RADIUS');
        $pulseColor = Configuration::get('IDNK_GOTOTOP_PULSE_COLOR');
        $pulsetransColor = Configuration::get('IDNK_GOTOTOP_PULSE_COLOR_TRANS');
        $pulseSize = Configuration::get('IDNK_GOTOTOP_PULSE_SIZE');

        $this->context->smarty->assign(
            [
                'effectStyle' => $effectStyle,
                'fontColor' => $fontColor,
                'bgColor' => $bgColor,
                'fontSize' => $fontSize,
                'paddingSpace' => $paddingSpace,
                'borderColor' => $borderColor,
                'borderRadius' => $borderRadius,
                'pulseColor' => $pulseColor,
                'pulsetransColor' => $pulsetransColor,
                'pulseSize' => $pulseSize
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
