<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 */

/**
 * Class BannersClass.
 */
class BannersClass extends ObjectModel
{
    /** @var int ID */
    public $id_banner_promo;

    /** @var string title */
    public $title;

    /** @var  string Long description */
    public $description;

    /** @var string image */
    public $image;

    /** @var string alt image */
    public $alt;

    /** @var string link image */
    public $link;

    /** @var bool Status for display Banner */
    public $active = true;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'banner_promo',
        'primary' => 'id_banner_promo',
        'multilang' => true,
        'multilang_shop' => true,
        'fields' => array(
            'active' => array('type' => self::TYPE_BOOL),
            'image' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName'),

            /* Lang fields Banner*/
            'description' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
            'title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName'),
            'link' => array('type' => self::TYPE_STRING, 'lang' => true, 'required' => true, 'validate' => 'isGenericName'),
            'alt' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName'),
        ),
    );


    /**
     * @param $value string image Banner
     * @return string src
     */
    public static function showBanner($value)
    {
        $src = __PS_BASE_URI__ . 'modules/bannerspromo/views/img/' . $value;
        return $value ? '<img src="' . $src . '" width="80" height="40px" class="img img-thumbnail"/>' : '-';
    }


    /**
     * @return array|null
     * @throws
     */
    public static function getBannersPromo()
    {
        $idLang = Context::getContext()->language->id;
        $query = new DbQuery();
        $query->select('b.*, bl.*');
        $query->from('banner_promo', 'b');
        $query->leftJoin('banner_promo_lang', 'bl', 'b.`id_banner_promo` = bl.`id_banner_promo`' . Shop::addSqlRestrictionOnLang('bl'));
        $query->where('b.`active` =  1 AND bl.`id_lang` =  ' . (int)$idLang);

        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($query);
    }
}
