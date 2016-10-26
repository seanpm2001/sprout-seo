<?php
namespace Craft;

class SproutSeo_MetadataModel extends BaseModel
{
	/**
	 * @var array
	 */
	protected $searchMeta = array();

	/**
	 * @var array
	 */
	protected $robotsMeta = array();

	/**
	 * @var array
	 */
	protected $geographicMeta = array();

	/**
	 * @var array
	 */
	protected $openGraphMeta = array();

	/**
	 * @var array
	 */
	protected $twitterCardsMeta = array();

	/**
	 * @return array
	 */
	protected function defineAttributes()
	{
		$sitemap = array(
			'id'              => array(AttributeType::Number),
			'isNew'           => array(AttributeType::Bool, 'default' => false), // @todo - Can we just test for ID?
			'elementId'       => array(AttributeType::Number),
			'default'         => array(AttributeType::String), // @todo - ??
			'name'            => array(AttributeType::String),
			'handle'          => array(AttributeType::String),
			'hasUrls'         => array(AttributeType::Number),
			'url'             => array(AttributeType::String), // @todo - can we just test for URL format?
			'priority'        => array(AttributeType::Number, 'maxLength' => 2, 'decimals' => 1, 'default' => '0.5', 'required' => true),
			'changeFrequency' => array(AttributeType::String, 'maxLength' => 7, 'default' => 'weekly', 'required' => true),

			'urlEnabledSectionId'  => array(AttributeType::Number),
			'isCustom'             => array(AttributeType::Bool, 'default' => false, 'required' => true), // @todo - can we just test for urlEnabledSectionId?
			'type'                 => array(AttributeType::String), // @todo - clarify what type is
			'enabled'              => array(AttributeType::Bool, 'default' => false, 'required' => true),
			'locale'               => array(AttributeType::String),
			'schemaTypeId'         => array(AttributeType::String),
			'schemaOverrideTypeId' => array(AttributeType::String),
			'ogTransform'          => array(AttributeType::String),
			'twitterTransform'     => array(AttributeType::String),

			'dateUpdated' => array(AttributeType::DateTime),
			'dateCreated' => array(AttributeType::DateTime),
			'uid'         => array(AttributeType::String),
		);

		// @todo - do we need all these values here? Some could just be assigned elsewhere:
		// name => title, url => canonical, default not in use...
		$metaTags = array(
			'optimizedTitle'        => array(AttributeType::String),
			'optimizedDescription'  => array(AttributeType::String),
			'optimizedImage'        => array(AttributeType::String),
			'optimizedKeywords'     => array(AttributeType::String),
			'customizationSettings' => array(AttributeType::String),
		);

		$this->searchMeta = array(
			'title'            => array(AttributeType::String),
			'appendTitleValue' => array(AttributeType::String, 'default' => null),
			'description'      => array(AttributeType::String),
			'keywords'         => array(AttributeType::String),
		);

		$this->robotsMeta = array(
			'robots'    => array(AttributeType::String),
			'canonical' => array(AttributeType::String),
		);

		$this->geographicMeta = array(
			'region'    => array(AttributeType::String),
			'placename' => array(AttributeType::String),
			'position'  => array(AttributeType::String),
			'latitude'  => array(AttributeType::String),
			'longitude' => array(AttributeType::String),
		);

		$this->openGraphMeta = array(
			'ogType'        => array(AttributeType::String),
			'ogSiteName'    => array(AttributeType::String),
			'ogAuthor'      => array(AttributeType::String),
			'ogPublisher'   => array(AttributeType::String),
			'ogUrl'         => array(AttributeType::String),
			'ogTitle'       => array(AttributeType::String),
			'ogDescription' => array(AttributeType::String),
			'ogImage'       => array(AttributeType::String),
			'ogImageSecure' => array(AttributeType::String),
			'ogImageWidth'  => array(AttributeType::String),
			'ogImageHeight' => array(AttributeType::String),
			'ogImageType'   => array(AttributeType::String),
			'ogAudio'       => array(AttributeType::String),
			'ogVideo'       => array(AttributeType::String),
			'ogLocale'      => array(AttributeType::String),
		);

		$this->twitterCardsMeta = array(
			'twitterCard'                    => array(AttributeType::String),
			'twitterSite'                    => array(AttributeType::String),
			'twitterCreator'                 => array(AttributeType::String),
			'twitterUrl'                     => array(AttributeType::String),
			'twitterTitle'                   => array(AttributeType::String),
			'twitterDescription'             => array(AttributeType::String),
			'twitterImage'                   => array(AttributeType::String),
			'twitterPlayer'                  => array(AttributeType::String),
			'twitterPlayerStream'            => array(AttributeType::String),
			'twitterPlayerStreamContentType' => array(AttributeType::String),
			'twitterPlayerWidth'             => array(AttributeType::String),
			'twitterPlayerHeight'            => array(AttributeType::String),
		);

		$attributes = array_merge(
			$sitemap,
			$metaTags,
			$this->searchMeta,
			$this->robotsMeta,
			$this->geographicMeta,
			$this->openGraphMeta,
			$this->twitterCardsMeta
		);

		return $attributes;
	}

	/**
	 * @return array
	 */
	public function getMetaTagData()
	{
		$metaTagData = array();

		$metaTagData['search']      = $this->getSearchMetaTagData();
		$metaTagData['robots']      = $this->getRobotsMetaTagData();
		$metaTagData['geo']         = $this->getGeographicMetaTagData();
		$metaTagData['openGraph']   = $this->getOpenGraphMetaTagData();
		$metaTagData['twitterCard'] = $this->getTwitterCardMetaTagData();
		$metaTagData['googlePlus']  = $this->getGooglePlusMetaTagData();

		return $metaTagData;
	}

	/**
	 * @param string $type
	 * @param array  $overrideInfo
	 *
	 * @return $this
	 * @throws \Exception
	 */
	public function setMeta($type = SproutSeo_MetadataLevels::GlobalMetadata, $overrideInfo = array())
	{
		switch ($type)
		{
			case SproutSeo_MetadataLevels::CodeMetadata:
				$this->setAttributes($this->prepareCodeMetadata($overrideInfo));
				break;

			case SproutSeo_MetadataLevels::ElementMetadata:
				$this->setAttributes($this->prepareElementMetadata($overrideInfo));
				break;

			case SproutSeo_MetadataLevels::SectionMetadata:
				$this->setAttributes($this->prepareSectionMetadata($overrideInfo));
				break;

			case SproutSeo_MetadataLevels::GlobalMetadata:
				$this->setAttributes($this->prepareGlobalMetadata());
				break;
		}

		// moved to getPrioritizedMetadataModel just one time called.
		//SproutSeoOptimizeHelper::prepareAssetUrls($this);

		return $this;
	}

	/**
	 * @return mixed
	 */
	protected function prepareGlobalMetadata()
	{
		$globals = sproutSeo()->globalMetadata->getGlobalMetadata();

		return $globals->meta;
	}

	/**
	 * Create our default Section Metadata SproutSeo_MetaTagsModel
	 *
	 * @param $urlEnabledSection
	 *
	 * @return SproutSeo_MetadataModel
	 */
	protected function prepareSectionMetadata($urlEnabledSection)
	{
		$attributes = array();

		if ($urlEnabledSection)
		{
			$metaTagsModel = sproutSeo()->sectionMetadata->getSectionMetadataByInfo($urlEnabledSection);

			$attributes = $metaTagsModel->getAttributes();
		}

		return $attributes;
	}

	/**
	 * Get Element Metadata based on an Element ID
	 *
	 * @param $overrideInfo
	 *
	 * @return array
	 */
	protected function prepareElementMetadata($overrideInfo)
	{
		if (isset($overrideInfo['elementId']))
		{
			$locale          = (defined('CRAFT_LOCALE') ? CRAFT_LOCALE : craft()->locale->getId());
			$elementMetadata = sproutSeo()->elementMetadata->getElementMetadataByElementId($overrideInfo['elementId'], $locale);

			// Default to the current URL, if no overrides exist
			$elementMetadata->canonical  = SproutSeoOptimizeHelper::prepareCanonical($elementMetadata);
			$elementMetadata->ogUrl      = SproutSeoOptimizeHelper::prepareCanonical($elementMetadata);
			$elementMetadata->twitterUrl = SproutSeoOptimizeHelper::prepareCanonical($elementMetadata);

			return $elementMetadata->getAttributes();
		}

		return array();
	}

	/**
	 * Process any Meta Tags provided in via the templates and create a SproutSeo_MetaTagsModel
	 *
	 * @param $overrideInfo
	 *
	 * @return SproutSeo_MetadataModel
	 */
	protected function prepareCodeMetadata($overrideInfo)
	{
		if (!empty($overrideInfo))
		{
			return $overrideInfo;
		}

		return array();
	}

	/**
	 * @return array
	 */
	protected function getSearchMetaTagData()
	{
		$tagData = array();

		foreach ($this->searchMeta as $key => $value)
		{
			if ($this->{$key})
			{
				$value         = craft()->config->parseEnvironmentString($this->{$key});
				$tagData[$key] = $value;
			}
		}

		return $tagData;
	}

	/**
	 * @return array
	 */
	protected function getRobotsMetaTagData()
	{
		$tagData = array();

		foreach ($this->robotsMeta as $key => $value)
		{
			if ($this->{$key})
			{
				$value = $this->{$key};

				if ($key == 'robots')
				{
					$value = $this->robots;
				}

				$tagData[$key] = $value;
			}
		}

		return $tagData;
	}

	/**
	 * @return array
	 */
	protected function getGeographicMetaTagData()
	{
		$tagData = array();

		foreach ($this->geographicMeta as $key => $value)
		{
			if ($key == 'latitude' or $key == 'longitude')
			{
				break;
			}

			if ($this->{$key})
			{
				$value = $this[$key];

				if ($key == 'position')
				{
					$value = SproutSeoOptimizeHelper::prepareGeoPosition($this);
				}

				$tagData[$this->getMetaTagName($key)] = $value;
			}
		}

		return $tagData;
	}

	/**
	 * @return array
	 */
	protected function getOpenGraphMetaTagData()
	{
		$tagData = array();

		foreach ($this->openGraphMeta as $key => $value)
		{
			if ($this->{$key})
			{
				$value                                = craft()->config->parseEnvironmentString($this->{$key});
				$tagData[$this->getMetaTagName($key)] = $value;
			}
		}

		return $tagData;
	}

	/**
	 * @return array
	 */
	protected function getTwitterCardMetaTagData()
	{
		$tagData = array();

		foreach ($this->twitterCardsMeta as $key => $value)
		{
			if ($this->{$key})
			{
				$value                                = craft()->config->parseEnvironmentString($this->{$key});
				$tagData[$this->getMetaTagName($key)] = $value;
			}
		}

		return $tagData;
	}

	/**
	 * @return null
	 */
	public function getGooglePlusMetaTagData()
	{
		$tagData = SproutSeoOptimizeHelper::getGooglePlusPage();

		return $tagData;
	}

	/**
	 * @param $handle
	 *
	 * @return mixed
	 */
	protected function getMetaTagName($handle)
	{
		// Map tag names to their handles
		$tagNames = array(

			// Geographic
			'region'                         => 'geo.region',
			'placename'                      => 'geo.placename',
			'position'                       => 'geo.position',

			// Open Graph
			'ogType'                         => 'og:type',
			'ogSiteName'                     => 'og:site_name',
			'ogAuthor'                       => 'og:author',
			'ogPublisher'                    => 'og:publisher',
			'ogUrl'                          => 'og:url',
			'ogTitle'                        => 'og:title',
			'ogDescription'                  => 'og:description',
			'ogImage'                        => 'og:image',
			'ogImageSecure'                  => 'og:image:secure_url',
			'ogImageWidth'                   => 'og:image:width',
			'ogImageHeight'                  => 'og:image:height',
			'ogImageType'                    => 'og:image:type',
			'ogAudio'                        => 'og:audio',
			'ogVideo'                        => 'og:video',
			'ogLocale'                       => 'og:locale',

			// Twitter Cards
			'twitterCard'                    => 'twitter:card',
			'twitterSite'                    => 'twitter:site',
			'twitterCreator'                 => 'twitter:creator',
			'twitterTitle'                   => 'twitter:title',
			'twitterDescription'             => 'twitter:description',
			'twitterUrl'                     => 'twitter:url',
			'twitterImage'                   => 'twitter:image',
			'twitterPlayer'                  => 'twitter:player',
			'twitterPlayerStream'            => 'twitter:player:stream',
			'twitterPlayerStreamContentType' => 'twitter:player:stream:content_type',
			'twitterPlayerWidth'             => 'twitter:player:width',
			'twitterPlayerHeight'            => 'twitter:player:height',
		);

		return $tagNames[$handle];
	}

	/**
	 * @return array
	 **/
	public function getCustomizationSettings()
	{
		$response = array(
			'searchMetaSectionMetadataEnabled'  => 0,
			'openGraphSectionMetadataEnabled'   => 0,
			'twitterCardSectionMetadataEnabled' => 0,
			'geoSectionMetadataEnabled'         => 0,
			'robotsSectionMetadataEnabled'      => 0
		);

		if ($this->customizationSettings)
		{
			$response = json_decode($this->customizationSettings, true);
		}

		return $response;
	}
}