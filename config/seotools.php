<?php
/**
 * @see https://github.com/artesaos/seotools
 */

return [
    'meta' => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => "INGO Forum Bangladesh", // set false to total remove
            'titleBefore'  => false, // Put defaults.title before page title, like 'INGO Forum Bangladesh - Dashboard'
            'description'  => 'The INGO Forum is a platform for International Non-Governmental Organizations (INGOs) working in Bangladesh. Established in response to the evolving needs of the development sector', // set false to total remove
            'separator'    => ' - ',
            'keywords'     => [],
            'canonical'    => 'full', // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'robots'       => 'all', // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
        ],
        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
            'norton'    => null,
        ],

        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => 'INGO Forum Bangladesh', // set false to total remove
            'description' => 'The INGO Forum is a platform for International Non-Governmental Organizations (INGOs) working in Bangladesh.', // set false to total remove
            'url'         => false, // Set null for using Url::current(), set false to total remove
            'type'        => false,
            'site_name'   => false,
            'images'      => [url('public/frontend/images/logo.png')],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            //'card'        => 'summary',
            //'site'        => '@LuizVinicius73',
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title'       => 'INGO Forum Bangladesh', // set false to total remove
            'description' => 'The INGO Forum is a platform for International Non-Governmental Organizations (INGOs) working in Bangladesh. Established in response to the evolving needs of the development sector', // set false to total remove
            'url'         => 'full', // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'type'        => 'WebPage',
            'images'      => [url('public/frontend/images/logo.png')],
        ],
    ],
];
