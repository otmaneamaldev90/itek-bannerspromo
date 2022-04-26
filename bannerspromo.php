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
if (!defined('_PS_VERSION_')) {
    exit;
}

include_once(dirname(__FILE__) . '/classes/BannersClass.php');

class BannersPromo extends Module
{

    protected $_html = '';
    protected $templateFile;
    protected $domain;

    public function __construct()
    {
        $this->name = 'bannerspromo';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Otmane AMAL';
        $this->need_instance = 0;
        $this->secure_key = Tools::encrypt($this->name);
        $this->bootstrap = true;
        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);

        parent::__construct();

        $this->domain = 'Modules.Bannerspromo.Bannerspromo';
        $this->displayName = $this->trans('Banners promo', [], $this->domain);
        $this->description = $this->trans('Display banners promo in home page', [], $this->domain);

        $this->confirmUninstall = $this->trans('Are you sure you want to uninstall?', [], $this->domain);
        $this->img_path = $this->_path . 'views/img/';
        $this->templateFile = 'module:bannerspromo/views/templates/hook/banners_promo.tpl';
    }

    /**
     * @see Module::install()
     */
    public function install()
    {
        include(dirname(__FILE__) . '/sql/install.php');

        return parent::install()
            && $this->createTabs()
            && $this->registerHook('header')
            && $this->registerHook('displayHome');
    }

    /**
     * @see Module::uninstall()
     */
    public function uninstall()
    {
        include(dirname(__FILE__) . '/sql/uninstall.php');
        $this->removeTabs('AdminParentBanners');
        $this->removeTabs('AdminBannersPromo');
        return parent::uninstall();
    }

    /**
     * @see  CREATE TAB module in Dashboard
     */
    public function createTabs()
    {

        $idParent = (int)Tab::getIdFromClassName('AdminParentBanners');
        if (empty($idParent)) {
            $parent_tab = new Tab();
            $parent_tab->name = [];
            foreach (Language::getLanguages(true) as $lang) {
                $parent_tab->name[$lang['id_lang']] = $this->trans('Modules content', [], $this->domain);
            }
            $parent_tab->class_name = 'AdminParentBanners';
            $parent_tab->id_parent = 0;
            $parent_tab->module = $this->name;
            $parent_tab->icon = 'library_books';
            $parent_tab->add();
        }

        $tab = new Tab();
        $tab->name = [];
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = $this->trans('Banners promo', [], $this->domain);
        }
        $tab->class_name = 'AdminBannersPromo';
        $tab->id_parent = (int)Tab::getIdFromClassName('AdminParentBanners');
        $tab->module = $this->name;
        $tab->icon = 'library_books';
        $tab->add();

        return true;
    }

    /**
     * Remove Tabs module in Dashboard
     * @param $class_name string name Tab
     * @return bool
     * @throws
     * @throws
     */
    public function removeTabs($class_name)
    {
        if ($tab_id = (int)Tab::getIdFromClassName($class_name)) {
            $tab = new Tab($tab_id);
            $tab->delete();
        }
        return true;
    }

    /**
     * @return bool
     */
    public function isUsingNewTranslationSystem()
    {
        return true;
    }

    /**
     * @return void
     */
    public function hookHeader()
    {
        $this->context->controller->addCSS($this->_path . 'views/js/front.js');
        $this->context->controller->addCSS($this->_path . 'views/css/front.css');
    }

    /**
     * @return void
     */
    public function clearCache()
    {
        $this->_clearCache($this->templateFile);
    }

    /**
     * @return string
     */
    public function hookDisplayHome()
    {
        if (!$this->isCached($this->templateFile, $this->getCacheId($this->name))) {
            $banners = BannersClass::getBannersPromo();
            $this->context->smarty->assign(array(
                'banners' => $banners,
                'uri' => $this->img_path,
            ));
        }
        return $this->fetch($this->templateFile, $this->getCacheId($this->name));
    }
}
