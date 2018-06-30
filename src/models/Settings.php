<?php
/**
 * @link      https://sprout.barrelstrengthdesign.com/
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license   http://sprout.barrelstrengthdesign.com/license
 */

namespace barrelstrength\sproutseo\models;


use craft\base\Model;
use Craft;

class Settings extends Model
{
    /**
     * @var string
     */
    public $pluginNameOverride = '';

    /**
     * @var bool
     */
    public $appendTitleValue = false;

    /**
     * @var bool
     */
    public $displayFieldHandles = false;

    /**
     * @var bool
     */
    public $enableCustomSections = false;

    /**
     * @var bool
     */
    public $enableMetadataRendering = true;

    /**
     * @var bool
     */
    public $toggleMetadataVariable = false;

    /**
     * @var string
     */
    public $metadataVariable = 'metadata';

    /**
     * @var string
     */
    public $structureId = '';

    /**
     * @var bool
     */
    public $enable404RedirectLog = false;

    /**
     * @var int
     */
    public $totalElementsPerSitemap = 500;

    /**
     * @var bool
     */
    public $enableDynamicSitemaps = true;

    /**
     * @var int
     */
    public $total404Redirects = 500;

    /**
     * @var int
     */
    public $maxMetaDescriptionLength = 160;

    /**
     * @var bool
     */
    public $enableMultilingualSitemaps = false;

    /**
     * @var array
     */
    public $siteSettings = [];

    /**
     * @var array
     */
    public $groupSettings = [];

    /**
     * @return array
     */
    public function getSettingsNavItems()
    {
        return [
            'overview' => [
                'label' => Craft::t('sprout-seo', 'Overview'),
                'url' => 'sprout-seo/settings/overview',
                'selected' => 'overview',
                'template' => 'sprout-base-seo/settings/overview'
            ],
            'settingsHeading' => [
                'heading' => Craft::t('sprout-seo', 'Settings'),
            ],
            'general' => [
                'label' => Craft::t('sprout-seo', 'General'),
                'url' => 'sprout-seo/settings/general',
                'selected' => 'general',
                'template' => 'sprout-base-seo/settings/general'
            ],
            'sitemaps' => [
                'label' => Craft::t('sprout-seo', 'Sitemaps'),
                'url' => 'sprout-seo/settings/sitemaps',
                'selected' => 'sitemaps',
                'template' => 'sprout-base-seo/settings/sitemaps'
            ],
            'advanced' => [
                'label' => Craft::t('sprout-seo', 'Advanced'),
                'url' => 'sprout-seo/settings/advanced',
                'selected' => 'advanced',
                'template' => 'sprout-base-seo/settings/advanced',
            ],
            'integrationsHeading' => [
                'heading' => Craft::t('sprout-seo', 'Integrations'),
            ],
            'craftcommerce' => [
                'label' => Craft::t('sprout-seo', 'Craft Commerce'),
                'url' => 'sprout-seo/settings/craftcommerce',
                'selected' => 'craftcommerce',
                'template' => 'sprout-base-seo/_integrations/craftcommerce',
                'settingsForm' => false
            ],
            'sproutemail' => [
                'label' => Craft::t('sprout-seo', 'Sprout Email'),
                'url' => 'sprout-seo/settings/sproutemail',
                'selected' => 'sproutemail',
                'template' => 'sprout-base-seo/_integrations/sproutemail',
                'settingsForm' => false
            ],
            'sproutimport' => [
                'label' => Craft::t('sprout-seo', 'Sprout Import'),
                'url' => 'sprout-seo/settings/sproutimport',
                'selected' => 'sproutimport',
                'template' => 'sprout-base-seo/_integrations/sproutimport',
                'settingsForm' => false
            ]
        ];
    }
}