<?php
/**
 * @link      https://sprout.barrelstrengthdesign.com/
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license   http://sprout.barrelstrengthdesign.com/license
 */

namespace barrelstrength\sproutseo\models;


use barrelstrength\sproutbase\base\SproutSettingsInterface;
use craft\base\Model;
use Craft;

/**
 *
 * @property array $settingsNavItems
 */
class Settings extends Model implements SproutSettingsInterface
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
    public $total404Redirects = 250;

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
     * @inheritdoc
     */
    public function getSettingsNavItems(): array
    {
        return [
            'general' => [
                'label' => Craft::t('sprout-seo', 'General'),
                'url' => 'sprout-seo/settings/general',
                'selected' => 'general',
                'template' => 'sprout-seo/settings/general'
            ],
            'advanced' => [
                'label' => Craft::t('sprout-seo', 'Advanced'),
                'url' => 'sprout-seo/settings/advanced',
                'selected' => 'advanced',
                'template' => 'sprout-seo/settings/advanced',
            ]
        ];
    }
}