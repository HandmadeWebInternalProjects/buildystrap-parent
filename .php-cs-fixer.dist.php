<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$rules = [
    '@PSR12' => true,
    'array_syntax' => ['syntax' => 'short'],
    'cast_spaces' => ['space' => 'single'],
    'no_unused_imports' => true,
    'not_operator_with_space' => true,
    'ordered_imports' => [
        'imports_order' => ['class', 'function', 'const'],
        'sort_algorithm' => 'alpha',
    ],
    'single_quote' => ['strings_containing_single_quote_chars' => true],
];

$finder = (new Finder())->exclude(['resources', 'vendor'])->in(__DIR__);

return (new Config())->setFinder($finder)->setRules($rules);
