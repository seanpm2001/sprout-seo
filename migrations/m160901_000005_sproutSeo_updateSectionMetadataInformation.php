<?php
namespace Craft;
/**
 * The class name is the UTC timestamp in the format of mYYMMDD_HHMMSS_pluginHandle_migrationName
 */
class m160901_000005_sproutSeo_updateSectionMetadataInformation extends BaseMigration
{
	/**
	 * Let's dance!
	 * @return bool
	 */
	public function safeUp()
	{
		$tableName = "sproutseo_metadata_sections";
		$enableCustom = false;

		if (craft()->db->tableExists($tableName))
		{
			// Find all Section Metadata Sections and set all the rows as custom pages
			$rows = craft()->db->createCommand()
				->select('id, handle, name')
				->from($tableName)
				->queryAll();

			foreach ($rows as $row)
			{
				// let's validate any possible duplicate handle
				$urlEnabledSectionTypes = sproutSeo()->sectionMetadata->getUrlEnabledSectionTypes();

				foreach ($urlEnabledSectionTypes as $urlEnabledSectionTypeKey => $urlEnabledSectionType)
				{
					foreach ($urlEnabledSectionType->urlEnabledSections as $urlEnabledSectionKey => $urlEnabledSection)
					{
						$sectionMetadata = $urlEnabledSection->sectionMetadata;

						if (isset($sectionMetadata->name))
						{
							if (isset($sectionMetadata->handle))
							{
								$handle = $sectionMetadata->handle;

								if ($row['handle'] == $handle)
								{
									$row['handle'] = "sproutSeo".ucfirst($row['handle']);
									break 2;
								}
							}
						}
					}
				}

				craft()->db->createCommand()->update($tableName,
					array('isCustom' => 1, 'handle' => $row['handle']),
					'id = :id',
					array(':id' => $row['id'])
				);

				$enableCustom = true;
			}

			if ($enableCustom)
			{
				$sproutSeo = craft()->plugins->getPlugin( 'sproutseo' );
				$settings  = $sproutSeo->getSettings();

				$settings['enableCustomSections'] = 1;
				craft()->plugins->savePluginSettings( $sproutSeo, $settings );
			}

			// Move globalFallback to globals

			$globalFallback = craft()->db->createCommand()
				->select('*')
				->from($tableName)
				->where('globalFallback = 1')
				->queryRow();

			if ($globalFallback)
			{
				$identity = array();
				$values['meta'] = json_encode($globalFallback);

				$identity['name']          = $globalFallback['title'];
				$identity['alternateName'] = "";
				$identity['logo']          = "";
				$identity['email']         = "";
				$identity['telephone']     = "";
				$identity['logo']          = "";
				$identity['@type']         = "Organization";
				$identity['foundingDate']  = "";
				$identity['openingHours']  = "";
				$identity['gender']        = "";
				$identity['description']   = $globalFallback['description'];
				$identity['keywords']      = $globalFallback['keywords'];
				$identity['url']           = $globalFallback['url'];
				$identity['organizationSubTypes'] = "";

				$values['identity'] = json_encode($identity);

				if ($globalFallback['robots'])
				{
					$robotsArray = explode(",", $globalFallback['robots']);
					$robotsSettings = array();

					foreach ($robotsArray as $key => $value)
					{
						$robotsSettings[$value] = 1;
					}

					$robots = array(
						'noindex'      => 0,
						'nofollow'     => 0,
						'noarchive'    => 0,
						'noimageindex' => 0,
						'noodp'        => 0,
						'noydir'       => 0,
					);

					foreach ($robots as $key => $value)
					{
						if (isset($robotsSettings[$key]))
						{
							$robots[$key] = 1;
						}
					}

					$values['robots'] = json_encode($robots);
				}

				$result = craft()->db->createCommand()->update('sproutseo_metadata_globals',
					$values,
					'id=:id',
					array(':id' => 1)
				);
 			}

 			// We no longer need the Global Fallback column
			if (craft()->db->columnExists($tableName, 'globalFallback'))
			{
				$this->dropColumn($tableName, 'globalFallback');
			}
		}
		else
		{
			SproutSeoPlugin::log("Table {$tableName} does not exists", LogLevel::Error, true);
		}

		return true;
	}
}