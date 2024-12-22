<?php


use Bits\IsoProductfeed\Contao\DC_IsoProductfeed;
use Bits\IsoProductfeed\Model\ShopConfig;
use Bits\IsoProductfeed\Model\Attribute;


$GLOBALS['TL_DCA']['tl_iso_productfeed'] = array
(
    // Config
    'config' => array
    (
        'dataContainer'             => DC_IsoProductfeed::class,
       // 'backlink'                  => 'do=iso_setup',
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
            'fields'                => array('title'),
            'flag'                  => 1,
            'panelLayout'           => 'search,limit'
        ),
        'label' => array
        (
            'fields'                => array('title'),
            'showColumns'           => true
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
            ),
            'delete' => array
            (
                'href'              => 'act=delete',
                'icon'              => 'delete.svg'
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
        'default'                   => '{global_legend},shop_config,title,description,link;{product_legend},g_id,g_title,g_description,g_link,g_image,g_price,g_sale_price,g_availability',
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
            'exclude'               => true,
            'inputType'             => 'select',
            'options_callback'      => function() {
                return ShopConfig::findShopConfigurations();
            },
            'eval'                  => array('mandatory'=>true, 'tl_class'=>'w50'),
            'sql'                   => "varchar(64) NOT NULL default ''"
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
            'eval'                  => array('style'=>'height:160px', 'tl_class'=>'clr'),
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
            'inputType'             => 'select',
            'default'               => 'sku',
            'options_callback'      => function() {
                return Attribute::getOptions();
            },
            'eval'                  => array('mandatory'=>true, 'tl_class'=>'w50'),
            'sql'                   => "varchar(64) NOT NULL default ''"
        ),
        'g_title' => array
        (
            'exclude'               => true,
            'inputType'             => 'select',
            'default'               => 'name',
            'options_callback'      => function() {
                return Attribute::getOptions();
            },
            'eval'                  => array('mandatory'=>true, 'tl_class'=>'w50'),
            'sql'                   => "varchar(64) NOT NULL default ''"
        ),
        'g_description' => array
        (
            'exclude'               => true,
            'inputType'             => 'select',
            'default'               => 'description',
            'options_callback'      => function() {
                return Attribute::getOptions();
            },
            'eval'                  => array('mandatory'=>true, 'tl_class'=>'w50'),
            'sql'                   => "varchar(64) NOT NULL default ''"
        ),
        'g_link' => array
        (
            'exclude'               => true,
            'inputType'             => 'select',
            'default'               => 'pages',
            'options_callback'      => function() {
                return Attribute::getOptions();
            },
            'eval'                  => array('mandatory'=>true, 'tl_class'=>'w50'),
            'sql'                   => "varchar(64) NOT NULL default ''"
        ),
        'g_image' => array
        (
            'exclude'               => true,
            'inputType'             => 'select',
            'default'               => 'images',
            'options_callback'      => function() {
                return Attribute::getOptions();
            },
            'eval'                  => array('mandatory'=>true, 'tl_class'=>'w50'),
            'sql'                   => "varchar(64) NOT NULL default ''"
        ),
        'g_price' => array
        (
            'exclude'               => true,
            'inputType'             => 'select',
            'default'               => 'price',
            'options_callback'      => function() {
                return Attribute::getOptions();
            },
            'eval'                  => array('mandatory'=>true, 'tl_class'=>'w50'),
            'sql'                   => "varchar(64) NOT NULL default ''"
        ),
        'g_sale_price' => array
        (
            'exclude'               => true,
            'inputType'             => 'select',
            'default'               => 'price',
            'options_callback'      => function() {
                return Attribute::getOptions();
            },
            'eval'                  => array('mandatory'=>false, 'tl_class'=>'w50'),
            'sql'                   => "varchar(64) NOT NULL default ''"
        ),
        'g_availability' => array
        (
            'exclude'               => true,
            'inputType'             => 'select',
            'default'               => 'type',
            'options_callback'      => function() {
                return Attribute::getOptions();
            },
            'eval'                  => array('mandatory'=>true, 'tl_class'=>'w50'),
            'sql'                   => "varchar(64) NOT NULL default ''"
        )
        
    )
);