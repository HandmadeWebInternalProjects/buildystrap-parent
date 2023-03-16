<?php

namespace Buildystrap\Builder\Layout;

use Buildystrap\Builder\Extends\Layout;
use Buildystrap\Str;

use function get_field;
use function view;

class Row extends Layout
{
  protected array $columns = [];
  protected array | int $colCount = [];

  public function __construct(array $row, ?Layout $parent = null)
  {
    parent::__construct($row, $parent);

    foreach ($row['columns'] ?? [] as $column) {
      $this->columns[] = new Column($column, $this);
    }

    $this->colCount = $this->getConfig('columnCount') ?? count($this->columns);
  }

  public function columns(): array
  {
    return $this->columns;
  }

  public function render(): string
  {
    $this->augmentOnce();

    return view('builder::row')->with('row', $this)->render();
  }

  protected function generateClasses(): void
  {
    parent::generateClasses();

    // Check if the row has an override for flex / grid specifically
    $hasClassOverride = parent::getClasses()->filter(function ($class) {
      return Str::contains($class, ['-grid', '-inline', '-block', '-none']);
    })->isNotEmpty();

    // If it does, don't add the default flex / grid classes
    if ($hasClassOverride) {
      return;
    }

    $class = '';

    // Add grid or d-flex onto the row based on the grid system default
    if (function_exists('get_field') && $grid_defaults = get_field(
      'buildystrap_structure_default_grid_system',
      'option'
    )) {
      $class = match ($grid_defaults) {
        'grid' => 'grid', // Grid
        default => 'row', // Flex
      };
    }

    // if columns is not divisible by 12, then we can change the column count in the grid so it works
    if (is_array($this->colCount)) {
      foreach ($this->colCount as $breakpoint => $columns) {
        if ($breakpoint === 'xs') {
          $breakpoint = '';
        } else {
          $breakpoint = "-{$breakpoint}";
        }
        $this->inline_styles[] = "--bs-columns{$breakpoint}: {$columns};";
      }
    } else if ($this->colCount && (12 % $this->colCount !== 0 || $this->colCount > 12)) {
      $this->inline_styles[] = "--bs-columns: {$this->colCount};";
    }


    $this->html_classes['xs'] = $class;
  }
}
