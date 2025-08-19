<?php

return [

  'default' => 'single',

  'deprecations' => [
    'channel' => 'single',
    'trace' => false,
  ],

  'channels' => [
    'null' => [
      'driver' => 'monolog',
      'handler' => \Monolog\Handler\NullHandler::class,
    ],

    'stack' => [
      'driver' => 'stack',
      'channels' => ['single'],
      'ignore_exceptions' => false,
    ],

    // Silence fallback single driver too
    'single' => [
      'driver' => 'monolog',
      'handler' => \Monolog\Handler\NullHandler::class,
    ],

    'daily' => [
      'driver' => 'monolog',
      'handler' => \Monolog\Handler\NullHandler::class,
    ],

    'emergency' => [
      'driver' => 'monolog',
      'handler' => \Monolog\Handler\NullHandler::class,
    ],
  ],

];
