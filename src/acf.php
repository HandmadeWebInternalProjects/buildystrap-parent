<?php

use Buildystrap\Builder;

$locations = collect(Builder::enabledTypes())->map(function ($type) {
    return [
        [
            'param' => 'post_type',
            'operator' => '==',
            'value' => $type,
        ],
    ];
})->toArray();

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group([
        'key' => 'group_62a8120d30f91',
        'title' => 'Backend Editor',
        'fields' => [
            [
                'key' => 'field_62a812895b588',
                'label' => 'Enabled',
                'name' => 'buildy::enabled',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => [
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ],
                'message' => '',
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ],
        ],
        'location' => $locations,
        'menu_order' => 0,
        'position' => 'side',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ]);
}
