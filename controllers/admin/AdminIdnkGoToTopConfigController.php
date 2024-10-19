<?php

class AdminIdnkGoToTopConfigController extends ModuleAdminController
{
    public function __construct()
    {
        $this->name = 'AdminIdnkGoToTopConfig';
        $this->bootstrap = true;
        $this->table = 'configuration';
        $this->identifier = 'name';
        $this->className = 'Configuration';
        $this->toolbar_title = 'Go to top';
        $this->page_header_toolbar_title = 'Go to top';
        $this->tab = 'front_office_features';

        parent::__construct();
        $this->meta_title = $this->l('IDNK Go to Top configuration');
    }

    public function renderForm()
    {
        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

        $fields_form[0]['form'] = [
            'legend' => [
                'title' => $this->l('Settings'),
            ],
            'input' => [
                [
                    'type' => 'select',
                    'label' => $this->trans('Effects Style', [], 'Modules.IdnkGoToTop.Admin') . ' <i class="icon icon-bookmark-empty"></i>',
                    'name' => 'IDNK_GOTOTOP_DESIGN',
                    'desc' => $this->trans('Select design for miniature prodcut.', [], 'Modules.IdnkGoToTop.Admin'),
                    'options' => [
                        'query' => [
                            [
                                'id' => 'style01',
                                'name' => $this->l('Default'),
                            ],
                            [
                                'id' => 'style02',
                                'name' => $this->l('Style 02'),
                            ],
                            [
                                'id' => 'style03',
                                'name' => $this->l('Style 03'),
                            ],
                            [
                                'id' => 'style04',
                                'name' => $this->l('Style 04'),
                            ],
                            [
                                'id' => 'style05',
                                'name' => $this->l('Style 05'),
                            ],
                            [
                                'id' => 'style06',
                                'name' => $this->l('Style 06'),
                            ],
                            [
                                'id' => 'style07',
                                'name' => $this->l('Style 07'),
                            ],
                            [
                                'id' => 'style08',
                                'name' => $this->l('Style 08'),
                            ],
                            [
                                'id' => 'style09',
                                'name' => $this->l('Style 09'),
                            ],
                            [
                                'id' => 'style10',
                                'name' => $this->l('Style 10'),
                            ],
                            [
                                'id' => 'style11',
                                'name' => $this->l('Style 11'),
                            ],
                        ],
                        'id' => 'id',
                        'name' => 'name',
                    ],
                ],
                [
                    'type' => 'color',
                    'label' => $this->l('Font Color'),
                    'name' => 'IDNK_GOTOTOP_FONT_COLOR',
                    'desc' => $this->l('Select font color for the arrow.'),
                    'required' => true
                ],
                [
                    'type' => 'color',
                    'label' => $this->l('Background Color'),
                    'name' => 'IDNK_GOTOTOP_BG_COLOR',
                    'desc' => $this->l('Select background color for the arrow.'),
                    'required' => true
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Font size'),
                    'name' => 'IDNK_GOTOTOP_FONT_SIZE',
                    'desc' => $this->l('Put size for font: 18px, 1.5rem.'),
                    'size' => 20,
                    'col' => '4',
                    'required' => false
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Padding space'),
                    'name' => 'IDNK_GOTOTOP_PADDING',
                    'desc' => $this->l('Put padding for space: 8px, 0.5rem.'),
                    'size' => 10,
                    'col' => '4',
                    'required' => false
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Border'),
                    'name' => 'IDNK_GOTOTOP_BORDER',
                    'desc' => $this->l('Config for border: 1px solid #000.'),
                    'size' => 50,
                    'col' => '4',
                    'required' => false
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Border radius'),
                    'name' => 'IDNK_GOTOTOP_BORDER_RADIUS',
                    'desc' => $this->l('Config for border radius: 50%.'),
                    'size' => 10,
                    'col' => '4',
                    'required' => false
                ],
                [
                    'type' => 'color',
                    'label' => $this->l('Color Effect Pulse'),
                    'name' => 'IDNK_GOTOTOP_PULSE_COLOR',
                    'desc' => $this->l('Select color for pulse effect.'),
                    'required' => true
                ],
                [
                    'type' => 'color',
                    'label' => $this->l('Color Effect Pulse transparency'),
                    'name' => 'IDNK_GOTOTOP_PULSE_COLOR_TRANS',
                    'desc' => $this->l('Select color for transparency pulse effect.'),
                    'required' => true
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Pulse Size'),
                    'name' => 'IDNK_GOTOTOP_PULSE_SIZE',
                    'desc' => $this->l('Config for Pulse size.'),
                    'size' => 10,
                    'col' => '4',
                    'required' => false
                ],
            ],
            'submit' => [
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right'
            ]
        ];

        $helper = new HelperForm();

        $helper->module = $this->module;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminIdnkGoToTopConfig'); // Use the correct controller name
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->module->name;

        // Language
        $helper->default_form_language = $default_lang;
        $helper->allow_employee_form_lang = $default_lang;

        // Title and toolbar
        $helper->title = $this->module->displayName;
        $helper->show_toolbar = true;        // false -> remove toolbar
        $helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
        $helper->submit_action = 'submit'.$this->module->name;
        $helper->toolbar_btn = [
            'save' => [
                'desc' => $this->l('Save'),
                'href' => AdminController::$currentIndex.'&configure='.$this->module->name.'&save'.$this->module->name.
                    '&token='.Tools::getAdminTokenLite('AdminIdnkGoToTopConfig'), // Use the correct controller name
            ],
            'back' => [
                'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminIdnkGoToTopConfig'), // Use the correct controller name
                'desc' => $this->l('Back to list')
            ]
        ];

        // Load current value
        $helper->fields_value['IDNK_GOTOTOP_DESIGN'] = Configuration::get('IDNK_GOTOTOP_DESIGN');
        $helper->fields_value['IDNK_GOTOTOP_FONT_COLOR'] = Configuration::get('IDNK_GOTOTOP_FONT_COLOR');
        $helper->fields_value['IDNK_GOTOTOP_BG_COLOR'] = Configuration::get('IDNK_GOTOTOP_BG_COLOR');
        $helper->fields_value['IDNK_GOTOTOP_FONT_SIZE'] = Configuration::get('IDNK_GOTOTOP_FONT_SIZE');
        $helper->fields_value['IDNK_GOTOTOP_PADDING'] = Configuration::get('IDNK_GOTOTOP_PADDING');
        $helper->fields_value['IDNK_GOTOTOP_BORDER'] = Configuration::get('IDNK_GOTOTOP_BORDER');
        $helper->fields_value['IDNK_GOTOTOP_BORDER_RADIUS'] = Configuration::get('IDNK_GOTOTOP_BORDER_RADIUS');
        $helper->fields_value['IDNK_GOTOTOP_PULSE_COLOR'] = Configuration::get('IDNK_GOTOTOP_PULSE_COLOR');
        $helper->fields_value['IDNK_GOTOTOP_PULSE_COLOR_TRANS'] = Configuration::get('IDNK_GOTOTOP_PULSE_COLOR_TRANS');
        $helper->fields_value['IDNK_GOTOTOP_PULSE_SIZE'] = Configuration::get('IDNK_GOTOTOP_PULSE_SIZE');

        return $helper->generateForm($fields_form);
    }

    public function postProcess()
    {
        if (Tools::isSubmit('submit'.$this->module->name)) {
            $effectStyle = (string)Tools::getValue('IDNK_GOTOTOP_DESIGN');
            $fontColor = (string)Tools::getValue('IDNK_GOTOTOP_FONT_COLOR');
            $bgColor = (string)Tools::getValue('IDNK_GOTOTOP_BG_COLOR');
            $fontSize = (string)Tools::getValue('IDNK_GOTOTOP_FONT_SIZE');
            $paddingSpace = (string)Tools::getValue('IDNK_GOTOTOP_PADDING');
            $borderColor = (string)Tools::getValue('IDNK_GOTOTOP_BORDER');
            $borderRadius = (string)Tools::getValue('IDNK_GOTOTOP_BORDER_RADIUS');
            $pulseColor = (string)Tools::getValue('IDNK_GOTOTOP_PULSE_COLOR');
            $pulsetransColor = (string)Tools::getValue('IDNK_GOTOTOP_PULSE_COLOR_TRANS');
            $pulseSize = (string)Tools::getValue('IDNK_GOTOTOP_PULSE_SIZE');

            // Guardar los valores en la configuración
            Configuration::updateValue('IDNK_GOTOTOP_DESIGN', $effectStyle);
            Configuration::updateValue('IDNK_GOTOTOP_FONT_COLOR', $fontColor);
            Configuration::updateValue('IDNK_GOTOTOP_BG_COLOR', $bgColor);
            Configuration::updateValue('IDNK_GOTOTOP_FONT_SIZE', $fontSize);
            Configuration::updateValue('IDNK_GOTOTOP_PADDING', $paddingSpace);
            Configuration::updateValue('IDNK_GOTOTOP_BORDER', $borderColor);
            Configuration::updateValue('IDNK_GOTOTOP_BORDER_RADIUS', $borderRadius);
            Configuration::updateValue('IDNK_GOTOTOP_PULSE_COLOR', $pulseColor);
            Configuration::updateValue('IDNK_GOTOTOP_PULSE_COLOR_TRANS', $pulsetransColor);
            Configuration::updateValue('IDNK_GOTOTOP_PULSE_SIZE', $pulseSize);

            $this->confirmations[] = $this->l('Settings updated');
        }

        return parent::postProcess();
    }

    public function initContent()
    {
        // Inicializa el contenido de la página
        $this->display = 'edit';
        parent::initContent();
    }
}
