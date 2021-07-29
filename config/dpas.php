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
         * to rename by service name or use default names
         *
         * STUBS
         * implemented patterns to generate related files
         */
        'Abstract' => [
            'steps' => [],
            'details' => [],
            'rename' => [],
            'stubs' => [],
            'msg' => ''
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
            'msg' => "\nImplement Setters and Getter in Builders directory classes.
                      \nImplement needed items in classes directory which extends from abstract class.
                      \nTo access final object, use Director class any where as needed.",
        ],//
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
            'msg' => '',
        ],//
        'Prototype' => [
            'steps' => [],
            'details' => [],
            'rename' => [],
            'stubs' => [],
            'msg' => '',
        ],
        'Singleton' => [
            'steps' => [],
            'details' => [],
            'rename' => [],
            'stubs' => [],
            'msg' => '',
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
            'msg' => 'Handle third part service in Api directory and your application custom process in Client Directory.',
        ],//
        'Bridge' => [
            'steps' => [],
            'details' => [],
            'rename' => [],
            'stubs' => [],
            'msg' => '',
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
            'msg' => '',
        ],//
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
            'msg' => '',
        ],//
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
            'msg' => '',
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
            'msg' => '',
        ],//
        'CoR' => [
            'steps' => [
                'c', 'c', 'a', 'c'
            ],
            'details' => [
                '/ServiceNameHandler', '/StatusManager', '/classes/Checker', '/classes/ItemOne'
            ],
            'rename' => [
                true, '', '', ''
            ],
            'stubs' => [
                '/cor/handler', '', '/cor/checker', '/cor/itemOne'
            ],
            'msg' => "\nadd chains to classes directory by extending Checker class.
                      \nImplement StatusManager according to service logic.
                      \nTo access final object, use <ServiceName>Handler class any where as needed.",
        ],//
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
            'msg' => '',
        ],
        'Iterator' => [
            'steps' => [],
            'details' => [],
            'rename' => [],
            'stubs' => [],
            'msg' => '',
        ],
        'Mediator' => [
            'steps' => [],
            'details' => [],
            'rename' => [],
            'stubs' => [],
            'msg' => '',
        ],
        'Memento' => [
            'steps' => [],
            'details' => [],
            'rename' => [],
            'stubs' => [],
            'msg' => '',
        ],
        'Observer' => [
            'steps' => [],
            'details' => [],
            'rename' => [],
            'stubs' => [],
            'msg' => '',
        ],
        'State' => [
            'steps' => [],
            'details' => [],
            'rename' => [],
            'stubs' => [],
            'msg' => '',
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
            'msg' => 'Implement strategies in Service classes directory. Update custom service provider, config and ENV files.',
        ],//
        'Template' => [
            'steps' => [],
            'details' => [],
            'rename' => [],
            'stubs' => [],
            'msg' => '',
        ],
        'Visitor' => [
            'steps' => [],
            'details' => [],
            'rename' => [],
            'stubs' => [],
            'msg' => '',
        ],
    ]
];
