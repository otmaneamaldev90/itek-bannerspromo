{*
* 2007-2016 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

{if isset($banners) && !empty($banners)}
    <div class="row">
        <div class="block-title-banner">
            <h2 class="title-light">
                {l s='Title' d='Modules.Bannerspromo.Bannerspromo'}
            </h2>
            <p class="subtitle-bold">
                {l s='Sub title' d='Modules.Bannerspromo.Bannerspromo'}
            </p>
        </div>
        {foreach from=$banners item=banner}
            <div class="col-md-4">
                <div class="">
                    {if isset($banner.image) && !empty($banner.image)}
                        <img
                                class="replace-2x img-responsive"
                                src="{$uri}{$banner.image|escape:'html':'UTF-8'}"
                                alt="{if $banner.alt}{$banner.alt|escape:'htmlall':'UTF-8'}{/if}"
                                title="{if $banner.title}{$banner.title|escape:'htmlall':'UTF-8'}{/if}"
                                width="100%;" />
                    {/if}
                </div>
                <div class="">
                    <div class="banner-button">
                        <a href="{$banner.link|escape:'html':'UTF-8'}">
                            <span>
                                {l s='Descover' d='Modules.Bannerspromo.Bannerspromo'}
                            </span>
                        </a>
                    </div>
                    {if isset($banner.description) && !empty($banner.description)}
                        <div class="banner-desc">
                            {$banner.description nofilter}
                        </div>
                    {/if}
                </div>
            </div>
        {/foreach}
    </div>
{/if}