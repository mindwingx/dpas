<?php

return [
    'patterns' => [
        'creational' => ["Builder", "Factory"],
        'structural' => ["Adapter", "Composite", "Decorator", "Proxy"],
        'behavioural' => ["CoR", "Strategy"]
    ],
    'implement' => [
        /**
         * STEPS
         * type of classes
         * i : interface
         * c : class
         * a : abstract class
         * p : service provider
         *
         * DETAILS
         * set path and name of related classes
         *
         * RENAME
         * map to DETAILS to replace service name with stub variables with aliased to "dummy"
         *
         * STUBS
         * implemented patterns to generate related files
         */
        'Abstract' => [
            'steps' => [],
            'details' => [],
            'rename' => [],
            'stubs' => [],
        ],

        'Builder' => [
            'steps' => [
                'i', 'c', 'c', 'a', 'c'
            ],
            'details' => [
                '/interfaces/ServiceName',
                '/ServiceNameDirector',
                '/builders/ServiceNameBuilder',
                '/classes/ServiceName',
                '/classes/ServiceNameItem',
            ],
            'rename' => [
                true, true, true, true, true
            ],
            'stubs' => [
                '', '/builder/builderDirector', 'classImp', 'abstractClass', 'classXtd'
            ],
        ],

        'Factory' => [
            'steps' => [
                'i', 'c', 'i', 'c', 'p'
            ],
            'details' => [
                '/interfaces/ServiceName',
                '/classes/ServiceName',
                '/interfaces/ServiceNameManager',
                '/ServiceNameManager',
                ''
            ],
            'rename' => [
                true, true, true, true, ''
            ],
            'stubs' => [

                '', 'classImp', '', 'classImp', '/factory/factoryServiceProvider'
            ],
        ],

        'Prototype' => [
            'steps' => [],
            'details' => [],
            'rename' => [],
            'stubs' => [],
        ],

        'Singleton' => [
            'steps' => [],
            'details' => [],
            'rename' => [],
            'stubs' => [],
        ],

        'Adapter' => [
            'steps' => [
                'i', 'c', 'c', 'p'
            ],
            'details' => [
                '/interfaces/ServiceName', '/classes/Client', '/classes/Api', ''
            ],
            'rename' => [
                true, '', '', ''
            ],
            'stubs' => [

                '', 'classImp', 'classImp', '/adaptor/adaptorServiceProvider'
            ],
        ],

        'Bridge' => [
            'steps' => [],
            'details' => [],
            'rename' => [],
            'stubs' => [],
        ],

        'Composite' => [
            'steps' => [
                'i', 'c', 'c', 'c', 'p'
            ],
            'details' => [
                '/interfaces/ServiceName',
                '/classes/Item', '/classes/Group',
                '/ServiceNameComponent',
                ''
            ],
            'rename' => [
                true, '', '', true, ''
            ],
            'stubs' => [
                '/composite/compositeInterface',
                '/composite/item',
                '/composite/group',
                '/composite/component',
                '/composite/compositeServiceProvider'
            ],
        ],

        'Decorator' => [
            'steps' => [
                'i', 'c', 'c', 'c', 'c', 'p'
            ],
            'details' => [
                '/interfaces/ServiceName',
                '/classes/ServiceNameBase',
                '/classes/ServiceNameItemOne',
                '/classes/ServiceNameItemTwo',
                '/ServiceName',
                ''
            ],
            'rename' => [
                true, true, true, true, true, ''
            ],
            'stubs' => [
                '',
                'classImp',
                '/decorator/classItem',
                '/decorator/classItem',
                '/decorator/classDecorator',
                '/decorator/decoratorServiceProvider'
            ],
        ],

        'Facade' => [
            'steps' => [],
            'details' => [],
            'rename' => [],
            'stubs' => [],
            'msg' => '',
        ],

        'Flyweight' => [
            'steps' => [],
            'details' => [],
            'rename' => [],
            'stubs' => [],
        ],

        'Proxy' => [
            'steps' => [
                'i', 'c', 'c', 'c', 'p'
            ],
            'details' => [
                '/interfaces/ServiceName',
                '/classes/MainServiceName',
                '/classes/ProxyServiceName',
                '/ServiceName',
                ''
            ],
            'rename' => [
                true, true, true, true, ''
            ],
            'stubs' => [
                '',
                'classImp',
                'classImp',
                '',
                'proxy/proxyServiceProvider'
            ],
        ],

        'CoR' => [
            'steps' => [
                'c', 'c', 'a', 'c'
            ],
            'details' => [
                '/ServiceNameHandler', '/StatusManager', '/classes/ServiceChecker', '/classes/ItemOne'
            ],
            'rename' => [
                true, '', '', ''
            ],
            'stubs' => [
                '/cor/handler', '', '/cor/checker', '/cor/itemOne'
            ],
        ],

        'Command' => [
            'steps' => [],
            'details' => [],
            'rename' => [],
            'stubs' => [],
            'msg' => '',
        ],

        'Interpreter' => [
            'steps' => [],
            'details' => [],
            'rename' => [],
            'stubs' => [],
        ],

        'Iterator' => [
            'steps' => [],
            'details' => [],
            'rename' => [],
            'stubs' => [],
        ],

        'Mediator' => [
            'steps' => [],
            'details' => [],
            'rename' => [],
            'stubs' => [],
        ],

        'Memento' => [
            'steps' => [],
            'details' => [],
            'rename' => [],
            'stubs' => [],
        ],

        'Observer' => [
            'steps' => [],
            'details' => [],
            'rename' => [],
            'stubs' => [],
        ],

        'State' => [
            'steps' => [],
            'details' => [],
            'rename' => [],
            'stubs' => [],
        ],

        'Strategy' => [
            'steps' => [
                'i', 'c', 'c', 'p'
            ],
            'details' => [
                '/interfaces/ServiceName', '/classes/FirstStrategy', '/classes/SecondStrategy', ''
            ],
            'rename' => [
                true, '', '', ''
            ],
            'stubs' => [
                '', 'classImp', 'classImp', '/strategy/strategyServiceProvider'
            ],
        ],

        'Template' => [
            'steps' => [],
            'details' => [],
            'rename' => [],
            'stubs' => [],
        ],

        'Visitor' => [
            'steps' => [],
            'details' => [],
            'rename' => [],
            'stubs' => [],
        ],
    ]
];
