<?php

return [
    '__name' => 'lib-appium',
    '__version' => '1.7.0',
    '__git' => 'git@github.com:getmim/lib-appium.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'https://iqbalfn.com/'
    ],
    '__files' => [
        'modules/lib-appium' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'lib-curl' => null
            ]
        ],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'LibAppium\\Library' => [
                'type' => 'file',
                'base' => 'modules/lib-appium/library'
            ]
        ],
        'files' => []
    ],
    '__inject' => [
        [
            'name' => 'libAppium',
            'children' => [
                [
                    'name' => 'host',
                    'question' => 'Appium Server hostname',
                    'default' => '127.0.0.1',
                    'rule' => '!^.+$!'
                ],
                [
                    'name' => 'port',
                    'question' => 'Appium Server port number',
                    'default' => '4723',
                    'rule' => '!^.+$!'
                ]
            ]
        ]
    ]
];
