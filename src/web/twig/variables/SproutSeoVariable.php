<?php
/**
 * @link      https://sprout.barrelstrengthdesign.com/
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license   http://sprout.barrelstrengthdesign.com/license
 */

namespace barrelstrength\sproutseo\web\twig\variables;

use barrelstrength\sproutseo\base\Schema;
use barrelstrength\sproutseo\helpers\SproutSeoOptimizeHelper;
use barrelstrength\sproutseo\SproutSeo;
use Craft;
use craft\elements\Asset;

use DateTime;
use craft\fields\PlainText;
use craft\fields\Assets;

/**
 * Class SproutSeoVariable
 *
 * @package Craft
 */
class SproutSeoVariable
{
    /**
     * @var SproutSeo
     */
    protected $plugin;

    /**
     * SproutSeoVariable constructor.
     */
    public function __construct()
    {
        $this->plugin = Craft::$app->plugins->getPlugin('sprout-seo');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->plugin->getName();
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->plugin->getVersion();
    }

    /**
     * Sets SEO metadata in templates
     *
     * @param array $meta Array of supported meta values
     */
    public function meta(array $meta = [])
    {
        if (count($meta)) {
            SproutSeo::$app->optimize->updateMeta($meta);
        }
    }

    /**
     * Prepare an array of the optimized Meta
     *
     * @return array[][]
     */
    public function getOptimizedMeta()
    {
        $prioritizedMetadataModel = SproutSeo::$app->optimize->getOptimizedMeta();

        return $prioritizedMetadataModel->getMetaTagData();
    }

    /**
     * Returns all templates
     *
     * @return mixed
     */
    public function getSectionMetadata()
    {
        return SproutSeo::$app->sectionMetadata->getSectionMetadata();
    }

    /**
     * Returns a specific template if found
     *
     * @param int $id
     *
     * @return null|mixed
     */
    public function getSectionMetadataById($id)
    {
        return SproutSeo::$app->sectionMetadata->getSectionMetadataById($id);
    }

    /**
     * @param array|null $options
     *
     * @return array|string
     * @throws \Twig_Error_Loader
     * @throws \yii\base\Exception
     */
    public function getSitemap(array $options = null)
    {
        return SproutSeo::$app->sitemap->getSitemap($options);
    }

    /**
     * Returns all URL-Enabled Sections Types
     *
     * @param null $siteId
     *
     * @return mixed
     * @throws \craft\errors\SiteNotFoundException
     */
    public function getUrlEnabledSectionTypes($siteId = null)
    {
        return SproutSeo::$app->sectionMetadata->getUrlEnabledSectionTypes($siteId);
    }

    /**
     * Returns all custom pages for sitemap settings
     *
     * @return array of Sections
     */
    public function getCustomSections()
    {
        return SproutSeo::$app->sectionMetadata->getCustomSections();
    }

    /**
     * @return mixed
     * @throws \yii\base\Exception
     */
    public function getDivider()
    {
        $globals = SproutSeo::$app->globalMetadata->getGlobalMetadata();
        $divider = '';

        if (isset($globals['settings']['seoDivider'])) {
            $divider = $globals->settings['seoDivider'];
        }

        return $divider;
    }

    /**
     * @return \craft\base\Model|null
     */
    public function getSettings()
    {
        return Craft::$app->plugins->getPlugin('sprout-seo')->getSettings();
    }

    /**
     * @return \barrelstrength\sproutseo\models\Globals
     * @throws \yii\base\Exception
     */
    public function getGlobalMetadata()
    {
        return SproutSeo::$app->globalMetadata->getGlobalMetadata();
    }

    /**
     * @return \Twig_Markup
     */
    public function getKnowledgeGraphLinkedData()
    {
        return SproutSeo::$app->schema->getKnowledgeGraphLinkedData();
    }

    /**
     * @return mixed
     */
    public function getAssetElementType()
    {
        return Asset::class;
    }

    /**
     * @param $id
     *
     * @return \craft\base\ElementInterface|null
     */
    public function getElementById($id)
    {
        $element = Craft::$app->elements->getElementById($id);

        return $element != null ? $element : null;
    }

    /**
     * @return array
     */
    public function getOrganizationOptions()
    {
        $jsonLdFile = Craft::getAlias('@sproutseolib/jsonld/tree.jsonld');
        $tree = file_get_contents($jsonLdFile);
        $json = json_decode($tree, true);
        $jsonByName = [];

        foreach ($json['children'] as $key => $value) {
            if ($value['name'] === 'Organization') {
                $json = $value['children'];
                break;
            }
        }

        foreach ($json as $key => $value) {
            $jsonByName[$value['name']] = $value;
        }

        return $jsonByName;
    }

    /**
     * @param $string
     *
     * @return DateTime
     */
    public function getDate($string)
    {
        $date = new DateTime($string['date'], new \DateTimeZone(Craft::$app->timezone));

        return $date;
    }

    /**
     * @param $description
     *
     * @return mixed|string
     */
    public function getJsonName($description)
    {
        $name = preg_replace('/(?<!^)([A-Z])/', ' \\1', $description);

        if ($description == 'NGO') {
            $name = Craft::t('sprout-seo', 'Non Government Organization');
        }

        return $name;
    }

    /**
     * Returns global options given a schema type
     *
     * @param $schemaType
     *
     * @return array
     */
    public function getGlobalOptions($schemaType)
    {
        $options = [];

        switch ($schemaType) {
            case 'contacts':

                $options = [
                    [
                        'label' => Craft::t('sprout-seo', 'Select Type...'),
                        'value' => ''
                    ],
                    [
                        'label' => Craft::t('sprout-seo', 'Customer Service'),
                        'value' => 'customer service'
                    ],
                    [
                        'label' => Craft::t('sprout-seo', 'Technical Support'),
                        'value' => 'technical support'
                    ],
                    [
                        'label' => Craft::t('sprout-seo', 'Billing Support'),
                        'value' => 'billing support'
                    ],
                    [
                        'label' => Craft::t('sprout-seo', 'Bill Payment'),
                        'value' => 'bill payment'
                    ],
                    [
                        'label' => Craft::t('sprout-seo', 'Sales'),
                        'value' => 'sales'
                    ],
                    [
                        'label' => Craft::t('sprout-seo', 'Reservations'),
                        'value' => 'reservations'
                    ],
                    [
                        'label' => Craft::t('sprout-seo', 'Credit Card Support'),
                        'value' => 'credit card support'
                    ],
                    [
                        'label' => Craft::t('sprout-seo', 'Emergency'),
                        'value' => 'emergency'
                    ],
                    [
                        'label' => Craft::t('sprout-seo', 'Baggage Tracking'),
                        'value' => 'baggage tracking'
                    ],
                    [
                        'label' => Craft::t('sprout-seo', 'Roadside Assistance'),
                        'value' => 'roadside assistance'
                    ],
                    [
                        'label' => Craft::t('sprout-seo', 'Package Tracking'),
                        'value' => 'package tracking'
                    ]
                ];

                break;

            case 'social':

                $options = [
                    [
                        'label' => Craft::t('sprout-seo', 'Select...'),
                        'value' => ''
                    ],
                    [
                        'label' => Craft::t('sprout-seo', 'Facebook'),
                        'value' => 'Facebook'
                    ],
                    [
                        'label' => Craft::t('sprout-seo', 'Twitter'),
                        'value' => 'Twitter'
                    ],
                    [
                        'label' => Craft::t('sprout-seo', 'Google+'),
                        'value' => 'Google+'
                    ],
                    [
                        'label' => Craft::t('sprout-seo', 'Instagram'),
                        'value' => 'Instagram',
                        'icon' => 'ABCD'
                    ],
                    [
                        'label' => Craft::t('sprout-seo', 'YouTube'),
                        'value' => 'YouTube'
                    ],
                    [
                        'label' => Craft::t('sprout-seo', 'LinkedIn'),
                        'value' => 'LinkedIn'
                    ],
                    [
                        'label' => Craft::t('sprout-seo', 'Myspace'),
                        'value' => 'Myspace'
                    ],
                    [
                        'label' => Craft::t('sprout-seo', 'Pinterest'),
                        'value' => 'Pinterest'
                    ],
                    [
                        'label' => Craft::t('sprout-seo', 'SoundCloud'),
                        'value' => 'SoundCloud'
                    ],
                    [
                        'label' => Craft::t('sprout-seo', 'Tumblr'),
                        'value' => 'Tumblr'
                    ]
                ];

                break;

            case 'ownership':

                $options = [
                    [
                        'label' => Craft::t('sprout-seo', 'Select...'),
                        'value' => ''
                    ],
                    [
                        'label' => Craft::t('sprout-seo', 'Bing Webmaster Tools'),
                        'value' => 'bingWebmasterTools',
                        'metaTagName' => 'msvalidate.01'
                    ],
                    [
                        'label' => Craft::t('sprout-seo', 'Facebook App ID'),
                        'value' => 'facebookAppId',
                        'metaTagName' => 'fb:app_id'
                    ],
                    [
                        'label' => Craft::t('sprout-seo', 'Facebook Page'),
                        'value' => 'facebookPage',
                        'metaTagName' => 'fb:page_id'
                    ],
                    [
                        'label' => Craft::t('sprout-seo', 'Facebook Admins'),
                        'value' => 'facebookAdmins',
                        'metaTagName' => 'fb:admins'
                    ],
                    [
                        'label' => Craft::t('sprout-seo', 'Google Search Console'),
                        'value' => 'googleSearchConsole',
                        'metaTagName' => 'google-site-verification'
                    ],
                    [
                        'label' => Craft::t('sprout-seo', 'Pinterest'),
                        'value' => 'pinterest',
                        'metaTagName' => 'p:domain_verify'
                    ],
                    [
                        'label' => Craft::t('sprout-seo', 'Yandex Webmaster Tools'),
                        'value' => 'yandexWebmasterTools',
                        'metaTagName' => 'yandex-verification'
                    ]
                ];

                break;
        }

        return $options;
    }

    /**
     * @param $schemaType
     * @param $handle
     * @param $schemaGlobals
     *
     * @return array
     */
    public function getFinalOptions($schemaType, $handle, $schemaGlobals)
    {
        $options = $this->getGlobalOptions($schemaType);

        array_push($options, ['optgroup' => Craft::t('sprout-seo', 'Custom')]);

        $schemas = $schemaGlobals->{$schemaType} != null ? $schemaGlobals->{$schemaType} : [];

        foreach ($schemas as $schema) {
            if (!$this->isCustomValue($schemaType, $schema[$handle])) {
                array_push($options, ['label' => $schema[$handle], 'value' => $schema[$handle]]);
            }
        }

        array_push($options, ['label' => Craft::t('sprout-seo', 'Add Custom'), 'value' => 'custom']);

        return $options;
    }

    /**
     * Verifies on the Global Options array if option value given is custom
     *
     * @param $schemaType
     * @param $value
     *
     * @return bool
     */
    public function isCustomValue($schemaType, $value)
    {
        $options = $this->getGlobalOptions($schemaType);

        foreach ($options as $option) {
            if ($option['value'] == $value) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array
     * @throws \yii\base\Exception
     */
    public function getPriceRangeOptions()
    {
        $schemaType = 'identity';

        $options = [
            [
                'label' => Craft::t('sprout-seo', 'None'),
                'value' => ''
            ],
            [
                'label' => Craft::t('sprout-seo', '$'),
                'value' => '$'
            ],
            [
                'label' => Craft::t('sprout-seo', '$$'),
                'value' => '$$'
            ],
            [
                'label' => Craft::t('sprout-seo', '$$$'),
                'value' => '$$$'
            ],
            [
                'label' => Craft::t('sprout-seo', '$$$$'),
                'value' => '$$$$'
            ]
        ];

        $schemaGlobals = SproutSeo::$app->globalMetadata->getGlobalMetadata();

        $priceRange = null;

        if (isset($schemaGlobals[$schemaType]['priceRange'])) {
            $priceRange = $schemaGlobals[$schemaType]['priceRange'];
        }

        array_push($options, ['optgroup' => Craft::t('sprout-seo', 'Custom')]);

        if (!array_key_exists($priceRange, ['$' => 0, '$$' => 1, '$$$' => 2, '$$$$' => 4]) && $priceRange != '') {
            array_push($options, ['label' => $priceRange, 'value' => $priceRange]);
        }

        array_push($options, ['label' => Craft::t('sprout-seo', 'Add Custom'), 'value' => 'custom']);

        return $options;
    }

    /**
     * @return array
     * @throws \yii\base\Exception
     */
    public function getGenderOptions()
    {
        $schemaType = 'identity';
        $options = [
            [
                'label' => Craft::t('sprout-seo', 'None'),
                'value' => ''
            ],
            [
                'label' => Craft::t('sprout-seo', 'Female'),
                'value' => 'female'
            ],
            [
                'label' => Craft::t('sprout-seo', 'Male'),
                'value' => 'male',
            ]
        ];

        $schemaGlobals = SproutSeo::$app->globalMetadata->getGlobalMetadata();
        $gender = $schemaGlobals[$schemaType]['gender'];

        array_push($options, ['optgroup' => Craft::t('sprout-seo', 'Custom')]);

        if (!array_key_exists($gender, ['female' => 0, 'male' => 1]) && $gender != '') {
            array_push($options, ['label' => $gender, 'value' => $gender]);
        }

        array_push($options, ['label' => Craft::t('sprout-seo', 'Add Custom'), 'value' => 'custom']);

        return $options;
    }

    /**
     * @return array
     * @throws \yii\base\Exception
     */
    public function getAppendMetaTitleOptions()
    {
        $options = [
            [
                'label' => Craft::t('sprout-seo', 'None'),
                'value' => ''
            ],
            [
                'label' => Craft::t('sprout-seo', 'Site Name'),
                'value' => 'sitename'
            ]
        ];

        $schemaGlobals = SproutSeo::$app->globalMetadata->getGlobalMetadata();

        if (isset($schemaGlobals['settings']['appendTitleValue'])) {
            $appendTitleValue = $schemaGlobals['settings']['appendTitleValue'];

            array_push($options, ['optgroup' => Craft::t('sprout-seo', 'Custom')]);

            if (!array_key_exists($appendTitleValue, ['sitename' => 0]) && $appendTitleValue != '') {
                array_push($options, ['label' => $appendTitleValue, 'value' => $appendTitleValue]);
            }
        }

        array_push($options, ['label' => Craft::t('sprout-seo', 'Add Custom'), 'value' => 'custom']);

        return $options;
    }

    /**
     * @return array
     * @throws \yii\base\Exception
     */
    public function getSeoDividerOptions()
    {
        $options = [
            [
                'label' => Craft::t('sprout-seo', 'None'),
                'value' => ''
            ],
            [
                'label' => '-',
                'value' => '-'
            ],
            [
                'label' => '•',
                'value' => '•'
            ],
            [
                'label' => '|',
                'value' => '|'
            ],
            [
                'label' => '/',
                'value' => '/'
            ],
            [
                'label' => ':',
                'value' => ':'
            ],
        ];

        $schemaGlobals = SproutSeo::$app->globalMetadata->getGlobalMetadata();

        if (isset($schemaGlobals['settings']['seoDivider'])) {
            $seoDivider = $schemaGlobals['settings']['seoDivider'];

            array_push($options, ['optgroup' => Craft::t('sprout-seo', 'Custom')]);

            if (!array_key_exists($seoDivider, ['-' => 0, '•' => 1, '|' => 2, '/' => 3, ':' => 4]) && $seoDivider != '') {
                array_push($options, ['label' => $seoDivider, 'value' => $seoDivider]);
            }
        }

        array_push($options, ['label' => Craft::t('sprout-seo', 'Add Custom'), 'value' => 'custom']);

        return $options;
    }

    /**
     * Returns all plain fields available given a type
     *
     * @param string $type
     * @param null   $handle
     * @param null   $settings
     *
     * @return array
     */
    public function getOptimizedOptions($type = PlainText::class, $handle = null, $settings = null)
    {
        $options = [];
        $fields = Craft::$app->fields->getAllFields();
        $pluginSettings = Craft::$app->plugins->getPlugin('sprout-seo')->getSettings();

        $options[''] = Craft::t('sprout-seo', 'None');

        $options[] = ['optgroup' => Craft::t('sprout-seo', 'Generate from Existing Field')];

        foreach ($fields as $key => $field) {
            if (get_class($field) == $type) {
                $context = explode(':', $field->context);
                $context = $context[0] ?? 'global';

                if ($pluginSettings->displayFieldHandles) {
                    $options[$field->id] = $field->name.' – {'.$field->handle.'}';
                } else {
                    $options[$field->id] = $field->name;
                }
            }
        }

        $options[] = ['optgroup' => Craft::t('sprout-seo', 'Add Custom Field')];
        $options['manually'] = Craft::t('sprout-seo', 'Display Editable Field');

        $options['manually'] = Craft::t('sprout-seo', 'Display Editable Field');

        $options[] = ['optgroup' => Craft::t('sprout-seo', 'Define Custom Pattern')];

        if (!isset($options[$settings[$handle]]) && $settings[$handle] != 'manually') {
            $options[$settings[$handle]] = $settings[$handle];
        }

        $options['custom'] = Craft::t('sprout-seo', 'Add Custom Format');

        return $options;
    }

    /**
     * Returns keywords options
     *
     * @param string $type
     *
     * @return array
     */
    public function getKeywordsOptions($type = PlainText::class)
    {
        $options = [];
        $fields = Craft::$app->fields->getAllFields();
        $pluginSettings = Craft::$app->plugins->getPlugin('sprout-seo')->getSettings();

        $options[''] = Craft::t('sprout-seo', 'None');
        $options[] = ['optgroup' => Craft::t('sprout-seo', 'Use Existing Field')];

        foreach ($fields as $key => $field) {
            if (get_class($field) == $type) {
                $context = explode(':', $field->context);
                $context = $context[0] ?? 'global';

                if ($pluginSettings->displayFieldHandles) {
                    $options[$field->id] = $field->name.' – {'.$field->handle.'}';
                } else {
                    $options[$field->id] = $field->name;
                }
            }
        }

        $options[] = ['optgroup' => Craft::t('sprout-seo', 'Add Custom Field')];

        $options['manually'] = Craft::t('sprout-seo', 'Display Editable Field');

        return $options;
    }

    /**
     * Returns all plain fields available given a type
     *
     * @param $settings
     *
     * @return array
     */
    public function getOptimizedTitleOptions($settings)
    {
        return $this->getOptimizedOptions(PlainText::class, 'optimizedTitleField', $settings);
    }

    /**
     * Returns all plain fields available given a type
     *
     * @param $settings
     *
     * @return array
     */
    public function getOptimizedDescriptionOptions($settings)
    {
        return $this->getOptimizedOptions(PlainText::class, 'optimizedDescriptionField', $settings);
    }

    /**
     * Returns all plain fields available given a type
     *
     * @param $settings
     *
     * @return array
     */
    public function getOptimizedAssetsOptions($settings)
    {
        return $this->getOptimizedOptions(Assets::class, 'optimizedImageField', $settings);
    }

    /**
     * @param $value
     *
     * @return array|null
     */
    public function getCustomSettingFieldHandles($value)
    {
        // If there are no dynamic tags, just return the template
        if (strpos($value, '{') === false) {
            return null;
        }

        /**
         *  {           - our pattern starts with an open bracket
         *  <space>?    - zero or one space
         *  (object\.)? - zero or one characters that spell "object."
         *  (?<handles> - begin capture pattern and name it 'handles'
         *  [a-zA-Z_]*  - any number of characters in Craft field handles
         *  )           - end capture pattern named 'handles'
         */
        preg_match_all('/{ ?(object\.)?(?<handles>[a-zA-Z_]*)/', $value, $matches);

        if (count($matches['handles'])) {
            return array_unique($matches['handles']);
        }
    }

    /**
     * Returns all plain fields available given a type
     *
     * @return array
     * @throws \yii\base\Exception
     */
    public function getGlobalRobots()
    {
        $globals = SproutSeo::$app->globalMetadata->getGlobalMetadata();
        $robots = SproutSeoOptimizeHelper::prepareRobotsMetadataValue($globals->robots);

        return SproutSeoOptimizeHelper::prepareRobotsMetadataForSettings($robots);
    }

    /**
     * @return array
     */
    public function getLocaleOptions()
    {
        $locales = [
            [
                'value' => '',
                'label' => Craft::t('sprout-seo', 'Select locale...')
            ]
        ];

        foreach (Craft::$app->i18n->getAllLocales() as $locale) {
            array_push($locales, [
                'value' => $locale->id,
                'label' => $locale->name.' ('.$locale->id.')'
            ]);
        }

        return $locales;
    }

    /**
     * Returns registerSproutSeoSchemas hook
     *
     * @return array
     */
    public function getSchemas()
    {
        return SproutSeo::$app->optimize->getSchemas();
    }

    /**
     * Returns registerSproutSeoSchemas hook
     *
     * @return array
     */
    public function getSchemaOptions()
    {
        $schemas = SproutSeo::$app->optimize->getSchemas();

        ksort($schemas);

        foreach ($schemas as $schema) {
            if ($schema->isUnlistedSchemaType()) {
                unset($schemas[$schema->getUniqueKey()]);
            }
        }

        // Get a filtered list of our default Sprout SEO schema
        $defaultSchema = array_filter($schemas, function($map) {
            /**
             * @var Schema $map
             */
            return stripos($map->getUniqueKey(), 'craft-sproutseo') !== false;
        });

        // Get a filtered list of of any custom schema
        $customSchema = array_filter($schemas, function($map) {
            /**
             * @var Schema $map
             */
            return stripos($map->getUniqueKey(), 'craft-sproutseo') === false;
        });

        // Build our options
        $schemaOptions = ['' => Craft::t('sprout-seo', 'None'), ['optgroup' => Craft::t('sprout-seo', 'Default Types')]];

        $schemaOptions = array_merge($schemaOptions, array_map(function($schema) {
            return [
                'label' => $schema->getName(),
                'type' => $schema->getType(),
                'value' => $schema->getUniqueKey()
            ];
        }, $defaultSchema));

        if (count($customSchema)) {
            array_push($schemaOptions, ['optgroup' => Craft::t('sprout-seo', 'Custom Types')]);

            $schemaOptions = array_merge($schemaOptions, array_map(function($schema) {
                return [
                    'label' => $schema->getName(),
                    'type' => $schema->getType(),
                    'value' => $schema->getUniqueKey(),
                    'isCustom' => '1'
                ];
            }, $customSchema));
        }

        return $schemaOptions;
    }

    /**
     * Returns global contacts
     *
     * @return array
     * @throws \yii\base\Exception
     */
    public function getContacts()
    {
        $contacts = SproutSeo::$app->globalMetadata->getGlobalMetadata()->contacts;

        $contacts = $contacts ?: [];

        foreach ($contacts as &$contact) {
            $contact['type'] = $contact['contactType'];
            unset($contact['contactType']);
        }

        return $contacts;
    }

    /**
     * Returns global social profiles
     *
     * @return array
     * @throws \yii\base\Exception
     */
    public function getSocialProfiles()
    {
        $socials = SproutSeo::$app->globalMetadata->getGlobalMetadata()->social;

        $socials = $socials ?: [];

        foreach ($socials as &$social) {
            $social['name'] = $social['profileName'];
            unset($social['profileName']);
        }

        return $socials;
    }

    /**
     * @param $type
     *
     * @return array
     */
    private function getSchemaChildren($type)
    {
        $tree = SproutSeo::$app->schema->getVocabularies($type);
        $children = [];

        // let's assume 3 levels
        if (isset($tree['children'])) {
            foreach ($tree['children'] as $key => $level1) {
                $children[$key] = [];

                if (isset($level1['children'])) {
                    foreach ($level1['children'] as $key2 => $level2) {
                        $children[$key][$key2] = [];

                        if (isset($level2['children'])) {
                            foreach ($level2['children'] as $key3 => $level3) {
                                array_push($children[$key][$key2], $key3);
                            }
                        }
                    }
                }
            }
        }

        return $children;
    }

    /**
     * Prepare an array of the optimized Meta
     *
     * @param $schemas
     *
     * @return array[][]
     */
    public function getSchemaSubtypes($schemas)
    {
        $values = null;

        foreach ($schemas as $schema) {
            if (isset($schema['type'])) {
                $type = $schema['type'];

                // Create a generic first item in our list that matches the top level schema
                // We do this so we don't have a blank dropdown option for our secondary schemas
                $firstItem = [
                    $type => []
                ];

                if (!isset($schema['isCustom'])) {
                    $values[$schema['value']] = $this->getSchemaChildren($type);

                    if (count($values[$schema['value']])) {
                        $values[$schema['value']] = array_merge($firstItem, $values[$schema['value']]);
                    }
                }
            }
        }

        return $values;
    }

    /**
     * Prepare an array of the image transforms available
     *
     * @return array
     */
    public function getTransforms()
    {
        return SproutSeo::$app->sectionMetadata->getTransforms();
    }

    /**
     * @param $type
     * @param $metadataModel
     *
     * @return bool
     */
    public function hasActiveMetadata($type, $metadataModel)
    {
        switch ($type) {
            case 'search':

                if (($metadataModel['optimizedTitle'] || $metadataModel['title']) &&
                    ($metadataModel['optimizedDescription'] || $metadataModel['description'])
                ) {
                    return true;
                }

                break;

            case 'openGraph':

                if (($metadataModel['optimizedTitle'] || $metadataModel['title']) &&
                    ($metadataModel['optimizedDescription'] || $metadataModel['description']) &&
                    ($metadataModel['optimizedImage'] || $metadataModel['ogImage'])
                ) {
                    return true;
                }

                break;

            case 'twitterCard':

                if (($metadataModel['optimizedTitle'] || $metadataModel['title']) &&
                    ($metadataModel['optimizedDescription'] || $metadataModel['description']) &&
                    ($metadataModel['optimizedImage'] || $metadataModel['twitterImage'])
                ) {
                    return true;
                }

                break;
        }

        return false;
    }

    /**
     * Returns array of URL Enabled Section types and the name of Element ID associated with each
     *
     * @todo - rename this getElementIdName() or something like that
     *
     * @return array
     */
    public function getVariableIdNames()
    {
        return SproutSeo::$app->optimize->getVariableIdNames();
    }

    public function getDescriptionLength()
    {
        return SproutSeo::$app->settings->getDescriptionLength();
    }
}
