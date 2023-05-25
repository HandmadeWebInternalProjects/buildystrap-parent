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

      return null;
    })->filter();
  }
}
