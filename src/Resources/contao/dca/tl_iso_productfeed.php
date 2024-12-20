<?php

use Contao\DC_Table;


$GLOBALS['TL_DCA']['tl_iso_productfeed'] = array
(
    // Config
    'config' => array
    (
        'dataContainer'             => DC_Table::class,
       // 'enableVersioning'          => true,
       // 'backlink'                  => 'do=iso_setup',
        'onload_callback' => array
        (
         //   array('Isotope\Backend\ProductType\Callback', 'checkPermission'),
          //  array('Isotope\Backend\ProductType\Permission', 'check'),
			//array('tl_calendar', 'generateFeed')
		),
		'oncreate_callback' => array
		(
		//	array('tl_calendar', 'adjustPermissions')
		),
		'oncopy_callback' => array
		(
		//	array('tl_calendar', 'adjustPermissions')
		),
		'onsubmit_callback' => array
		(
		//	array('tl_calendar', 'scheduleUpdate')
        ),
        'sql' => array
        (
            'keys' => array
            (
                'id'        => 'primary'
            )
        )
    ),

    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                  => 1,
            'fields'                => array('name'),
            'flag'                  => 1,
            'panelLayout'           => 'filter;search,limit'
        ),
        /*'label' => array
        (
            'fields'                => array('name', 'variants', 'downloads', 'shipping_exempt'),
            'showColumns'           => true,
            'label_callback'        => array('\Isotope\Backend\ProductType\Label', 'generate')
        ),*/
        'global_operations' => array
        (
            'all' => array
            (
                'label'             => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'              => 'act=select',
                'class'             => 'header_edit_all'
               // 'attributes'        => 'onclick="Backend.getScrollOffset();"'
            )
        ),
        'operations' => array
        (
            'edit' => array
            (
                'href'              => 'act=edit',
                'icon'              => 'edit.svg'
            ),
            'copy' => array
            (
                'href'              => 'act=copy',
                'icon'              => 'copy.svg'
              //  'button_callback'   => array('Isotope\Backend\ProductType\Callback', 'copyProductType')
            ),
            'delete' => array
            (
                'href'              => 'act=delete',
                'icon'              => 'delete.svg'
            //    'attributes'        => 'onclick="if (!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? '') . '\')) return false; Backend.getScrollOffset();"',
            //    'button_callback'   => array('Isotope\Backend\ProductType\Callback', 'deleteProductType')
            ),
            'show' => array
            (
                'href'              => 'act=show',
                'icon'              => 'show.svg'
            )
        )
    ),

    // Palettes
    'palettes' => array
    (
        'default'                   => '{global_legend},shop_config,title,descrition,link;{product_legend},g_id,g_title,g_description,g_link,g_image,g_price,g_sale_price,g_availability',
    ),

    // Fields
    'fields' => array
    (
        'id' => array
        (
            'sql'                   =>  "int(10) unsigned NOT NULL auto_increment",
        ),
        'tstamp' => array
        (
            'sql'                   =>  "int(10) unsigned NOT NULL default '0'",
        ),
        //global_palette
        'shop_config' => array
		(
			'exclude'                 => true,
			'inputType'               => 'pageTree',
			'foreignKey'              => 'tl_iso_config.title',
			'eval'                    => array('mandatory'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
			'sql'                     => "int(10) unsigned NOT NULL default 0",
			'relation'                => array('type'=>'hasOne', 'load'=>'lazy')
		),
        'title' => array
        (
            'exclude'               => true,
            'search'                => true,
            'inputType'             => 'text',
            'eval'                  => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                   => "varchar(255) NOT NULL default ''",
        ),
        'description' => array
        (
            'exclude'               => true,
            'inputType'             => 'textarea',
            'eval'                  => array('style'=>'height:80px', 'tl_class'=>'clr'),
            'sql'                   => "text NULL",
        ),
        'link' => array
		(
			'exclude'                 => true,
			'inputType'               => 'pageTree',
			'foreignKey'              => 'tl_page.title',
			'eval'                    => array('mandatory'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
			'sql'                     => "int(10) unsigned NOT NULL default 0",
			'relation'                => array('type'=>'hasOne', 'load'=>'lazy')
		),
        //product_palette
        'g_id' => array
        (
            'exclude'               => true,
            'filter'                => true,
            'inputType'             => 'select',
            'default'               => 'standard',
            'options_callback'      => function() {
                return \Isotope\Model\Attribute::getModelTypeOptions();
            },
            'reference'             => &$GLOBALS['TL_LANG']['MODEL']['tl_iso_product'],
            'eval'                  => array('mandatory'=>true, 'submitOnChange'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'),
            'sql'                   => "varchar(64) NOT NULL default ''"
        ),
        'g_title' => array
        (
            'exclude'               => true,
            'filter'                => true,
            'inputType'             => 'select',
            'default'               => 'standard',
            'options_callback'      => function() {
                return \Isotope\Model\Attribute::getModelTypeOptions();
            },
            'reference'             => &$GLOBALS['TL_LANG']['MODEL']['tl_iso_product'],
            'eval'                  => array('mandatory'=>true, 'submitOnChange'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'),
            'sql'                   => "varchar(64) NOT NULL default ''"
        ),
        'g_description' => array
        (
            'exclude'               => true,
            'filter'                => true,
            'inputType'             => 'select',
            'default'               => 'standard',
            'options_callback'      => function() {
                return \Isotope\Model\Attribute::getModelTypeOptions();
            },
            'reference'             => &$GLOBALS['TL_LANG']['MODEL']['tl_iso_product'],
            'eval'                  => array('mandatory'=>true, 'submitOnChange'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'),
            'sql'                   => "varchar(64) NOT NULL default ''"
        ),
        'g_link' => array
        (
            'exclude'               => true,
            'filter'                => true,
            'inputType'             => 'select',
            'default'               => 'standard',
            'options_callback'      => function() {
                return \Isotope\Model\Attribute::getModelTypeOptions();
            },
            'reference'             => &$GLOBALS['TL_LANG']['MODEL']['tl_iso_product'],
            'eval'                  => array('mandatory'=>true, 'submitOnChange'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'),
            'sql'                   => "varchar(64) NOT NULL default ''"
        ),
        'g_image' => array
        (
            'exclude'               => true,
            'filter'                => true,
            'inputType'             => 'select',
            'default'               => 'standard',
            'options_callback'      => function() {
                return \Isotope\Model\Attribute::getModelTypeOptions();
            },
            'reference'             => &$GLOBALS['TL_LANG']['MODEL']['tl_iso_product'],
            'eval'                  => array('mandatory'=>true, 'submitOnChange'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'),
            'sql'                   => "varchar(64) NOT NULL default ''"
        ),
        'g_price' => array
        (
            'exclude'               => true,
            'filter'                => true,
            'inputType'             => 'select',
            'default'               => 'standard',
            'options_callback'      => function() {
                return \Isotope\Model\Attribute::getModelTypeOptions();
            },
            'reference'             => &$GLOBALS['TL_LANG']['MODEL']['tl_iso_product'],
            'eval'                  => array('mandatory'=>true, 'submitOnChange'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'),
            'sql'                   => "varchar(64) NOT NULL default ''"
        ),
        'g_sale_price' => array
        (
            'exclude'               => true,
            'filter'                => true,
            'inputType'             => 'select',
            'default'               => 'standard',
            'options_callback'      => function() {
                return \Isotope\Model\Attribute::getModelTypeOptions();
            },
            'reference'             => &$GLOBALS['TL_LANG']['MODEL']['tl_iso_product'],
            'eval'                  => array('mandatory'=>true, 'submitOnChange'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'),
            'sql'                   => "varchar(64) NOT NULL default ''"
        ),
        'g_availability' => array
        (
            'exclude'               => true,
            'filter'                => true,
            'inputType'             => 'select',
            'default'               => 'standard',
            'options_callback'      => function() {
                return \Isotope\Model\Attribute::getModelTypeOptions();
            },
            'reference'             => &$GLOBALS['TL_LANG']['MODEL']['tl_iso_product'],
            'eval'                  => array('mandatory'=>true, 'submitOnChange'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'),
            'sql'                   => "varchar(64) NOT NULL default ''"
        )
        
    )
);