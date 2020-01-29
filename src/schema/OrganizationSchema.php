<?php
/**
 * @link https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license https://craftcms.github.io/license
 */

namespace barrelstrength\sproutseo\schema;

class OrganizationSchema extends ThingSchema
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
     * @return bool
     */
    public function isUnlistedSchemaType()
    {
        return false;
    }
}