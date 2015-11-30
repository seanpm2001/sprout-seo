<?php
namespace Craft;

/**
 * Class SproutSeoPlugin
 *
 * @package Craft
 */
class SproutSeoPlugin extends BasePlugin
{
	/**
	 * @return string
	 */
	public function getName()
	{
		$pluginNameOverride = $this->getSettings()->getAttribute('pluginNameOverride');

		return empty($pluginNameOverride) ? Craft::t('Sprout SEO') : $pluginNameOverride;
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return 'All-in-One SEO, Social Media Sharing, Redirects, and Sitemap';
	}

	/**
	 * @return string
	 */
	public function getVersion()
	{
		return '1.1.1';
	}

	/**
	 * @return string
	 */
	public function getDeveloper()
	{
		return 'Barrel Strength Design';
	}

	/**
	 * @return string
	 */
	public function getDeveloperUrl()
	{
		return 'http://barrelstrengthdesign.com';
	}

	/**
	 * @return string
	 */
	public function getDocumentationUrl()
	{
		return 'http://sprout.barrelstrengthdesign.com/craft-plugins/seo/docs';
	}

	/**
	 * @return bool
	 */
	public function hasCpSection()
	{
		return true;
	}

	/**
	 * Get Settings URL
	 */
	public function getSettingsUrl()
	{
		return 'sproutseo/settings';
	}

	/* --------------------------------------------------------------
	 * HOOKS
	 * ------------------------------------------------------------ */

	public function init()
	{
		Craft::import('plugins.sproutseo.helpers.SproutSeoMetaHelper');

		if(craft()->request->isSiteRequest() && !craft()->request->isLivePreview())
		{
			$url = craft()->request->getUrl();
			// check if the request url needs redirect
			$redirect = sproutSeo()->redirects->getRedirect($url);

			if($redirect)
			{
				craft()->request->redirect($redirect->newUrl, true, $redirect->method);
			}
		}

		if (craft()->request->isCpRequest() && craft()->request->getSegment(1) == 'sproutseo')
		{
			// @todo Craft 3 - update to use info from config.json
			craft()->templates->includeJsResource('sproutseo/js/brand.js');
			craft()->templates->includeJs("
				sproutFormsBrand = new Craft.SproutBrand();
				sproutFormsBrand.displayFooter({
					pluginName: 'Sprout SEO',
					pluginUrl: 'http://sprout.barrelstrengthdesign.com/craft-plugins/seo',
					pluginVersion: '" . $this->getVersion() . "',
					pluginDescription: '" . $this->getDescription() . "',
					developerName: '(Barrel Strength)',
					developerUrl: '" . $this->getDeveloperUrl() . "'
				});
			");
		}
	}

	/**
	 * @return array
	 */
	protected function defineSettings()
	{
		// We are managing our settings on the CP Tab but storing them
		// in the plugin table so in order to use getSettings() we need
		// these defined here
		return array(
			'pluginNameOverride'  => AttributeType::String,
			'seoDivider'          => array(AttributeType::String, 'default' => '-'),
		);
	}

	/**
	 * @return array
	 */
	public function registerCpRoutes()
	{
		return array(
			'sproutseo/defaults/new' => array(
				'action' => 'sproutSeo/defaults/editDefault'
			),
			'sproutseo/defaults/(?P<defaultId>\d+)' => array(
				'action' => 'sproutSeo/defaults/editDefault'
			),
			'sproutseo/sitemap' => array(
				'action' => 'sproutSeo/sitemap/sitemapIndex'
			),
			'sproutseo/sitemap/newPage' => array(
				'action' => 'sproutSeo/sitemap/editSitemap'
			),
			'sproutseo/settings' => array(
				'action' => 'sproutSeo/settings/settingsIndex'
			),
			'sproutseo/redirects' => array(
				'action' => 'sproutSeo/redirects/redirectIndex'
			),
			'sproutseo/redirects/new' => array(
				'action' => 'sproutSeo/redirects/editRedirect'
			),
			'sproutseo/redirects/(?P<redirectId>\d+)' => array(
				'action' => 'sproutSeo/redirects/editRedirect'
			)
		);
	}
}

/**
 * @return SproutSeoService
 */
function sproutSeo()
{
	return Craft::app()->getComponent('sproutSeo');
}
