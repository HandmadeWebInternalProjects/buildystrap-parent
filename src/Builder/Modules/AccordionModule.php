<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder;
use Buildystrap\Builder\Extends\Module;

class AccordionModule extends Module
{

  public function __construct(array $module)
  {
    parent::__construct($module);

    $blueprintFields = static::getBlueprint()->get('fields');

    $values = $module['values'];

    $this->fields = collect($values)->map(function ($value, $handle) use ($blueprintFields) {
      if (!empty($blueprintFields[$handle]) && $blueprintField = $blueprintFields[$handle]) {
        if ($field = Builder::getField($blueprintField['type'])) {
          $fieldValue = $value;

          if (is_array($fieldValue)) {
            $fieldValue = collect($fieldValue)->map(function ($subField) use ($blueprintFields, $handle) {
              if (is_array($subField)) {
                foreach ($subField as $subHandle => $subValue) {
                  if (
                    isset($blueprintFields[$handle]['fields'][$subHandle]['type']) &&
                    $subFieldType = Builder::getField($blueprintFields[$handle]['fields'][$subHandle]['type'])
                  ) {

                    $subField[$subHandle] = new $subFieldType($subValue);
                  }
                }
              }
              return $subField;
            });
          }
          return new $field($fieldValue);
        }
      }
    })->filter();
  }

  protected static function blueprint(): array
  {
    return [
      'icon' => 'fa-solid fa-chevron-down',
      'fields' => [
        'accordion' => [
          'type' => 'replicator-field',
          'config' => [
            'label' => 'Accordion',
            'preview' => 'title'
          ],
          'fields' => [
            'title' => [
              'type' => 'text-field',
              'config' => [
                'label' => 'Title',
              ],
            ],
            'content' => [
              'type' => 'richtext-field',
              'config' => [
                'label' => 'Content',
              ],
            ],
            'cta' => [
              'type' => 'button-field',
              'config' => [
                'label' => 'CTA',
              ],
            ],
          ]
        ],
      ],
      'config' => [
        'selectorTab' => 'regular'
      ]
    ];
  }
}
