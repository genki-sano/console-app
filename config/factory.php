<?php

/**
 * @see https://github.com/zendframework/zend-servicemanager
 * @see https://zendframework.github.io/zend-servicemanager
 */
return [
    'services'           => [
    ],
    'invokables'         => [
    ],
    'factories'          => [
        \ConsoleApp\Console\Command\RssReaderCommand::class
        => \ConsoleApp\Console\Command\RssReaderCommandFactory::class,
    ],
    'abstract_factories' => [
    ],
    'delegators'         => [
    ],
    'aliases'            => [
    ],
    'initializers'       => [
    ],
    'lazy_services'      => [
    ],
    'shared'             => [
    ],
    'shared_by_default' => false,
];