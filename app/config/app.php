<?php
$router   = require 'router.php';
$db       = require 'db.php';

/**
 * 应用配置
 */
return [
    'debug'    => true,    // 是否debug
    'timezone' => 'PRC',   // 时区

    // 共用配置
    'params' => [
        'redis' => [
            'host'       => '127.0.0.1',
            'port'       => 6379,
            'auth'       => '',
            'persistent' => false,
            'index'      => 0,
        ]
    ],

    // 服务配置
    'services'  => [
        'eventsManager' => App\Providers\EventsManagerProvider::class,
        'router'        => [
            'className' => App\Providers\RouterProvider::class,
            'params'    => $router,
        ],
        'dispatcher' => App\Providers\DispatcherProvider::class,
        'crypt'      => [
            'className' => App\Providers\CryptProvider::class,
            'params'    => [
                'cryptKey' => 'fkakuZkp!HGys093HPH13HrHOBLDWur(',
            ]
        ],
        'session' => [
            'className' => App\Providers\SessionProvider::class,
            'params'    => [
                'adapter'  => 'files',
                'uniqueId' => 'app',
                'timeout'  => 60 * 20,
            ],
            // 'params^params.redis' => [
            //     'adapter'  => 'redis',
            //     'uniqueId' => 'app',
            //     'timeout'  => 60 * 20,
            //     'prefix'   => 'sess_',
            // ]
        ],
        'cookies' => [
            'className' => App\Providers\CookiesProvider::class,
            'params'    => [
                'expire'   => 0,
                'path'     => '/',
                'secure'   => false,
                'domain'   => '',
                'httpOnly' => '',
            ]
        ],
        'db' => [
            'className' => App\Providers\DbProvider::class,
            'params' => $db
        ],
        'modelsManager' => App\Providers\ModelsManagerProvider::class,
        'modelsCache' => [
            'className' => App\Providers\ModelsCacheProvider::class,
            'params' => [
                'adapter' => 'memory',
            ],
            // 'params' => [
            //     'adapter'  => 'file',
            //     'prefix'   => 'app',
            //     'cacheDir' => APP_PATH . '/var/cache/',
            //     'lifetime' => 3600,
            // ],
            // 'params^params.redis' => [
            //     'adapter'  => 'redis',
            //     'prefix'   => 'modelcache_',
            //     'lifetime' => 60 * 8,
            // ],
        ],
        'modelsMetadata' => [
            'className' => App\Providers\ModelsMetadataProvider::class,
            'params' => [
                'adapter' => 'memory',
            ],
            // 'params' => [
            //     'adapter'  => 'file',
            //     'prefix'   => 'metadata_',
            //     'metaDataDir' => APP_PATH . '/var/cache/',
            //     'lifetime' => 3600,
            // ],
            // 'params^params.redis' => [
            //     'adapter'  => 'redis',
            //     'prefix'   => 'metadata_',
            //     'lifetime' => 60 * 24 * 10,
            // ],
        ],
        'annotations' => [
            'className' => App\Providers\AnnotationsProvider::class,
            'params' => [
                'adapter'  => 'memory',
            ],
            // 'params' => [
            //     'adapter' => 'files',
            //     'annotationsDir' => APP_PATH . '/var/cache/',
            // ]
            // 'params^params.redis' => [
            //     'adapter'  => 'redis',
            //     'prefix'   => 'anno_',
            //     'lifetime' => 60 * 24 * 10,
            // ],
        ],
        'url' => App\Providers\UrlProvider::class,
    ],

    'listeners' => [],

    'modules' => [
        'admin' => []
    ],
];