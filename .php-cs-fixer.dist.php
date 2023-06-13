<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude([
        'app/Providers',
        'bootstrap',
        'config',
        'lang',
        'public',
        'storage',
    ])
    ->in(__DIR__);

$rules = [
    // Rules based on PhpCsFixer rule set with added or modified rules below.
    '@PhpCsFixer' => true,
    // List Notation
    'list_syntax' => [
        'syntax' => 'short',
    ],
    // Basic
    'curly_braces_position' => true,
    // Class Notation
    'ordered_class_elements' => [
        'order' => [
            'use_trait', 'case',
            'constant_public', 'constant_protected', 'constant_private',
            'property_public_readonly', 'property_protected_readonly', 'property_private_readonly',
            'property_public', 'property_protected', 'property_private',
            'property_public_static', 'property_protected_static', 'property_private_static',
            'method_public_abstract', 'method_protected_abstract', 'method_private_abstract',
            'method_public_abstract_static', 'method_protected_abstract_static', 'method_private_abstract_static',
            'construct', 'destruct', 'magic', 'phpunit',
            'method_public', 'method_protected', 'method_private',
            'method_public_static', 'method_protected_static', 'method_private_static',
        ],
    ],
    'ordered_interfaces' => true,
    'self_static_accessor' => true,
    'single_trait_insert_per_statement' => false,
    // Control Structure
    'control_structure_continuation_position' => [
        'position' => 'same_line',
    ],
    'no_alternative_syntax' => [
        'fix_non_monolithic_code' => false,
    ],
    'trailing_comma_in_multiline' => [
        'elements' => ['arguments', 'arrays', 'match', 'parameters'],
    ],
    'yoda_style' => false,
    // Function Notation
    'method_argument_space' => [
        'on_multiline' => 'ignore',
    ],
    'nullable_type_declaration_for_default_null_value' => false,
    // Operator
    'not_operator_with_space' => true,
    // PHP Tag
    'echo_tag_syntax' => [
        'format' => 'short',
    ],
    // PHPUnit
    'php_unit_internal_class' => false,
    'php_unit_method_casing' => [
        'case' => 'snake_case',
    ],
    'php_unit_test_class_requires_covers' => true,
    // PHPDoc
    'phpdoc_add_missing_param_annotation' => false,
    'phpdoc_align' => [
        'align' => 'left',
    ],
    'phpdoc_no_alias_tag' => [
        'replacements' => [
            'type' => 'var',
            'link' => 'see',
        ],
    ],
    'phpdoc_no_empty_return' => false,
    'phpdoc_order' => [
        'order' => ['property', 'property-write', 'property-read', 'method', 'param', 'return', 'throws'],
    ],
    // String Notation
    'explicit_string_variable' => false,
    // Whitespace
    'blank_line_between_import_groups' => false,
];

return (new PhpCsFixer\Config())
    ->setRules($rules)
    ->setCacheFile('.php-cs-fixer.cache')
    ->setIndent('    ')
    ->setLineEnding("\n")
    ->setFinder($finder);
