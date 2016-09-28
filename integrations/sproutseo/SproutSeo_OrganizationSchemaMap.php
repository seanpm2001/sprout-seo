<?php
namespace Craft;

class SproutSeo_OrganizationSchemaMap extends SproutSeoBaseSchemaMap
{
	/**
	 * @return string
	 */
	public function getName()
	{
		return 'Organization';
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return 'Organization';
	}

	/**
	 * @return array|null
	 */
	public function getProperties()
	{
		return array();
	}
}