<?php
return [
    DWenzel\T3events\Domain\Model\Event::class => [
        'subclasses' => [
            'Tx_T3eventsCourse_Course' => CPSIT\T3eventsCourse\Domain\Model\Course::class
        ]
    ],

    CPSIT\T3eventsCourse\Domain\Model\Course::class => [
        'tableName' => 'tx_t3events_domain_model_event',
        'recordType' => 'Tx_T3eventsCourse_Course',
        'properties' => [
            'extbaseType' => [
                'fieldName' => 'tx_extbase_type'
            ]
        ],
    ],

    DWenzel\T3events\Domain\Model\Performance::class => [
        'subclasses' => [
            'Tx_T3eventsCourse_Schedule' => CPSIT\T3eventsCourse\Domain\Model\Schedule::class
        ]
    ],

    CPSIT\T3eventsCourse\Domain\Model\Schedule::class => [
        'tableName' => 'tx_t3events_domain_model_performance',
        'recordType' => 'Tx_T3eventsCourse_Schedule'
    ],
];