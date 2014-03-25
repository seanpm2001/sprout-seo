<?php
namespace Craft;

require_once( dirname(__FILE__) . "/helpers/BSDPluginHelper.php" );

class SproutSeoPlugin extends BasePlugin
{
	public function getName()
	{
		// The plugin name
		$pluginName = Craft::t('Sprout SEO');

		// @TODO - Can we find a way to move this to the BSDPluginHelper function?
		// I can't seem to pass an object or find the object we are working with.
		$pluginClassHandle = $this->getClassHandle(__CLASS__);

		return BSDPluginHelper::getPluginName($pluginName, $pluginClassHandle);
	}

	public function getVersion()
	{
		return '0.6.2';
	}

	public function getDeveloper()
	{
		return 'Barrel Strength Design';
	}

	public function getDeveloperUrl()
	{
		return 'http://barrelstrengthdesign.com';
	}

	public function hasCpSection()
	{
		return true;
	}

	public function init()
	{
		craft()->on('entries.saveEntry', array($this, 'onSaveEntry'));
		craft()->on('content.saveContent', array($this, 'onSaveContent'));
	}

	public function onSaveEntry(Event $event)
	{
		// @TODO
		// Test and see if the Section Entry being saved belongs to 
		// a Section that we want to ping for.
		// Get Sitemap URL
		// Call ping function
	}

	public function onSaveContent(Event $event)
	{
		// @TODO
		// Test and see if the Section Entry being saved belongs to 
		// a Section that we want to ping for.
		// Get Sitemap
		// Call ping function
	}


	protected function defineSettings()
	{
		return array(
			'pluginNameOverride'  => AttributeType::String,
			'appendSiteName'      => AttributeType::Bool,
			'customGlobalValue'   => AttributeType::String,
			'seoDivider'          => AttributeType::String,
		);
	}

	public function getSettingsHtml()
	{
		return craft()->templates->render('sproutseo/_settings/settings', array(
			'settings' => $this->getSettings()
		));
	}

	/**
	 * Register control panel routes
	 */
	public function registerCpRoutes()
	{
		return array(
			'sproutseo/fallbacks/new' =>
			'sproutseo/fallbacks/_edit',

			'sproutseo/fallbacks/(?P<fallbackId>\d+)' =>
			'sproutseo/fallbacks/_edit',
		);
	}

}