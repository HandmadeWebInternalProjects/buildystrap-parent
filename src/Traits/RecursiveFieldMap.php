<?php

namespace Buildystrap\Traits;

use Buildystrap\Builder;

trait RecursiveFieldMap
{
  public function __construct(array $module)
  {
    parent::__construct($module, disable_fields: true);

    $blueprintFields = static::getBlueprint()->get('fields');

    $this->fields = $this->collectionClass($module['values'])->map(function ($value, $handle) use ($blueprintFields) {
      return $this->processField($value, $handle, $blueprintFields);
    })->filter();
  }

  private function processField($value, $handle, $blueprintFields)
  {
    if (!empty($blueprintFields[$handle]) && $blueprintField = $blueprintFields[$handle]) {
      if ($field = Builder::getField($blueprintField['type'])) {
        $fieldValue = $value;

        // Replicators
        if (is_array($fieldValue) && isset($blueprintField['fields']) && $blueprintField['type'] === 'replicator-field') {
          $fieldValue = collect($fieldValue)->map(function ($subField) use ($blueprintFields, $handle) {
            if (is_array($subField)) {
              foreach ($subField as $subHandle => $subValue) {
                if (
                  isset($blueprintFields[$handle]['fields'][$subHandle]['type']) &&
                  $subFieldType = Builder::getField($blueprintFields[$handle]['fields'][$subHandle]['type'])
                ) {
                  $subField[$subHandle] = $this->processField($subValue, $subHandle, $blueprintFields[$handle]['fields']);
                }
              }
            }
            return $subField;
          });

          return new $field($fieldValue);
        }

        // Groups
        if (isset($blueprintField['fields']) && $blueprintField['type'] === 'group-field') {
          $fieldValue = collect($fieldValue)->map(function ($subField, $subHandle) use ($blueprintField) {
            if (($blueprintField['fields'][$subHandle]['type'] ?? null) && $subFieldType = Builder::getField($blueprintField['fields'][$subHandle]['type'])) {
              return $this->processField($subField, $subHandle, $blueprintField['fields']);
            }
          });
        }

        return new $field($fieldValue);
      }
    }

    return null;
  }
}
