<?php

$rules = [
    '@PSR12' => true,
    'array_syntax' => ['syntax' => 'short'],
    'cast_spaces' => ['space' => 'single'],
    'ordered_imports' => ['imports_order' => ['class', 'function', 'const'], 'sort_algorithm' => 'alpha'],
    'no_closing_tag' => true,
    'no_unused_imports' => true,
    'not_operator_with_space' => true,
];

$config = new PhpCsFixer\Config();

return $config->setRules($rules);//->setFinder($finder);
