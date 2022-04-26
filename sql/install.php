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

$sql = [];

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'banner_promo` (
        `id_banner_promo` int(10) unsigned NOT NULL AUTO_INCREMENT,  
        `image` varchar(255) NOT NULL,
        `position` int(10) unsigned NOT NULL DEFAULT 0,
        `active` tinyint(1) unsigned NOT NULL DEFAULT 1, 
        PRIMARY KEY (`id_banner_promo`)
    ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 ;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'banner_promo_lang` (
        `id_banner_promo` int(10) unsigned NOT NULL, 
        `id_lang` int(10) unsigned NOT NULL, 
        `id_shop` int(10) unsigned NOT NULL DEFAULT 1,
        `alt` varchar(128) NOT NULL,
        `link` varchar(255) NOT NULL, 
        `title` varchar(128) NOT NULL, 
        `description` longtext,
        PRIMARY KEY (`id_banner_promo`, `id_shop`, `id_lang`)
    ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 ;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'banner_promo_shop` (
	`id_banner_promo` int(10) unsigned NOT NULL, 
	`id_shop` int(10) unsigned NOT NULL ,
	PRIMARY KEY (`id_banner_promo`, `id_shop`), 
	KEY `id_shop` (`id_shop`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 ;';


foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}