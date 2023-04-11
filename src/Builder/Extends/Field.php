<?php

namespace Buildystrap\Builder\Extends;

use Buildystrap\Traits\Augment;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;

use function collect;
use function is_string;

abstract class Field implements Htmlable
{
  use Augment;

  protected mixed $value;
  protected mixed $raw;
  protected string $additional_classes = '';

  public function __construct(mixed $value)
  {
    $this->value = $value;
    $this->raw = $value;
  }

  public static function getBlueprint(): Collection
  {
    return collect(static::blueprint());
  }

  abstract protected static function blueprint(): array;

  public function raw(): mixed
  {
    return $this->raw;
  }

  public function __toString(): string
  {
    $value = $this->value();

    return match (true) {
      is_string($value) => $value,
      default => "<!-- {$this->type()} could not output value as a string -->"
    };
  }

  public function toHtml(): string
  {
    return $this->__toString();
  }

  public function withClass(string $class): self
  {
    $this->additional_classes = $class;
    return $this;
  }

  public function value(): mixed
  {
    return $this->augmented()->value;
  }

  public static function process_merge_tags($input_string)
  {
    preg_match_all('/{([^}|]+)(\|[^}]+)?}/', $input_string, $matches);

    foreach ($matches[1] as $index => $match) {
      $id = get_the_ID();
      $match = trim($match);
      $parts = explode(':', $match);
      $function_type = trim($parts[0]);
      $function_name = "";
      $params = isset($matches[2][$index]) ? explode(',', trim($matches[2][$index], '| ')) : [];

      if (count($parts) > 1) {
        $field = $parts[1];
      }

      if ($function_type === 'acf') {
        $function_name = 'bs_get_field';
        array_unshift($params, $field, $id);
      } elseif ($function_type === 'meta') {
        $function_name = 'get_post_meta';
        array_unshift($params, $id, $field, true);
      } elseif ($function_type === 'thumbnail') {
        $function_name = 'get_the_post_thumbnail';
        $size = isset($params[0]) ? trim($params[0]) : 'full';
        $params = array($id, $size);
      } elseif ($function_type == 'date') {
        $function_name = 'get_the_date';
        $params = [];
      } else {
        $function_name = "get_the_{$match}";
        array_unshift($params, $id);
      }

      // Call the appropriate WordPress function with the spread args.
      if (function_exists($function_name)) {
        // json_decode each param to allow for passing arrays as params.
        $result = call_user_func_array($function_name, array_map('convert_param_value', $params));
        $input_string = str_replace($matches[0][$index], $result, $input_string);
      }
    }

    return $input_string;
  }
}
