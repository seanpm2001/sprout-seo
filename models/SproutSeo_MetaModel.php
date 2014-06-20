<?php
namespace Craft;

class SproutSeo_MetaModel extends BaseModel
{

    protected function defineAttributes()
    {
        return array(
            'id'             => array(AttributeType::Number),
            'name'           => array(AttributeType::String),
            'handle'         => array(AttributeType::String),
            'appendSiteName' => array(AttributeType::String),
            'globalFallback' => array(AttributeType::Bool),

            'title'          => array(AttributeType::String),
            'description'    => array(AttributeType::String),
            'keywords'       => array(AttributeType::String),

            'robots'         => array(AttributeType::String),
            'canonical'      => array(AttributeType::String),

            'region'         => array(AttributeType::String),
            'placename'      => array(AttributeType::String),
            'position'       => array(AttributeType::String),
            'latitude'       => array(AttributeType::String),
            'longitude'      => array(AttributeType::String),

            'ogTitle'        => array(AttributeType::String),
            'ogType'         => array(AttributeType::String),
            'ogUrl'          => array(AttributeType::String),
            'ogImage'        => array(AttributeType::String),
            'ogSiteName'     => array(AttributeType::String),
            'ogDescription'  => array(AttributeType::String),
            'ogAudio'        => array(AttributeType::String),
            'ogVideo'        => array(AttributeType::String),
            'ogLocale'       => array(AttributeType::String),

            // Store the Twitter Card Type
            // @TODO convert to enum with the proper choices
            'twitterCard' => array(
                AttributeType::String
            ),

            // Fields for Twitter Summary Card
            'twitterSummarySite' => array(
                AttributeType::String
            ),
            'twitterSummaryTitle' => array(
                AttributeType::String
            ),
            'twitterSummaryCreator' => array(
                AttributeType::String
            ),
            'twitterSummaryDescription' => array(
                AttributeType::String
            ),
            'twitterSummaryImageSource' => array(
                AttributeType::String
            ),

            // Fields for Twitter Summary Large Image Card
            'twitterSummaryLargeImageSite' => array(
                AttributeType::String
            ),
            'twitterSummaryLargeImageTitle' => array(
                AttributeType::String
            ),
            'twitterSummaryLargeImageCreator' => array(
                AttributeType::String
            ),
            'twitterSummaryLargeImageDescription' => array(
                AttributeType::String
            ),
            'twitterSummaryCreator' => array(
                AttributeType::String
            ),
            'twitterSummaryLargeImageImageSource' => array(
                AttributeType::String
            ),

            // Fields for Twitter Photo Card
            'twitterPhotoSite' => array(
                AttributeType::String
            ),
            'twitterPhotoTitle' => array(
                AttributeType::String,
            ),
            'twitterPhotoCreator' => array(
                AttributeType::String
            ),
            'twitterPhotoImageSource' => array(
                AttributeType::String,
            ),

            // Fields for Twitter Player Card
            'twitterPlayerSite' => array(
                AttributeType::String
            ),
            'twitterPlayerTitle' => array(
                AttributeType::String,
            ),
            'twitterPlayerCreator' => array(
                AttributeType::String
            ),
            'twitterPlayerDescription' => array(
                AttributeType::String,
            ),
            'twitterPlayerImageSource' => array(
                AttributeType::String,
            ),
            'twitterPlayer' => array(
                AttributeType::String,
            ),
            'twitterPlayerStream' => array(
                AttributeType::String,
            ),
            'twitterPlayerStreamContentType' => array(
                AttributeType::String,
            ),
            'twitterPlayerWidth' => array(
                AttributeType::String,
            ),
            'twitterPlayerHeight' => array(
                AttributeType::String,
            ),

        );
    }

}
