<?php

namespace Buildystrap\Tests\Unit;

use Buildystrap\Builder\Content;
use Buildystrap\Builder\Extends\Field;
use Buildystrap\Builder\Extends\Module;
use Buildystrap\Builder\Layout\Column;
use Buildystrap\Builder\Layout\Container;
use Buildystrap\Builder\Layout\Row;
use Buildystrap\Builder\Layout\Section;
use Buildystrap\Tests\TestCase;
use Illuminate\Support\Enumerable;

use function file_get_contents;
use function method_exists;

class BuilderTest extends TestCase
{
    public function test_can_use_schema()
    {
        // Schema
        $schema = $this->schema();
        $this->assertNotEmpty($schema);

        // Content
        $content = new Content($schema);

        // Container
        $container = $content->container();
        $this->assertInstanceOf(Container::class, $container);

        // Sections
        $this->assertTrue(method_exists($container, 'sections'));
        $this->assertInstanceOf(Enumerable::class, $container->sections());
        $this->assertNotEmpty($container->sections());

        foreach ($container->sections() as $section) {
            $this->assertInstanceOf(Section::class, $section);

            // Rows
            $this->assertTrue(method_exists($section, 'rows'));
            $this->assertInstanceOf(Enumerable::class, $section->rows());
            $this->assertNotEmpty($section->rows());

            foreach ($section->rows() as $row) {
                $this->assertInstanceOf(Row::class, $row);

                // Columns
                $this->assertTrue(method_exists($row, 'columns'));
                $this->assertInstanceOf(Enumerable::class, $row->columns());
                $this->assertNotEmpty($row->columns());

                foreach ($row->columns() as $column) {
                    $this->assertInstanceOf(Column::class, $column);

                    // Modules
                    $this->assertTrue(method_exists($column, 'modules'));
                    $this->assertInstanceOf(Enumerable::class, $column->modules());
                    $this->assertNotEmpty($column->modules());

                    foreach ($column->modules() as $module) {
                        $this->assertInstanceOf(Module::class, $module);

                        // Fields
                        $this->assertTrue(method_exists($module, 'fields'));
                        $this->assertInstanceOf(Enumerable::class, $module->fields());
                        $this->assertTrue($module->fields()->isNotEmpty());

                        foreach ($module->fields() as $field) {
                            $this->assertInstanceOf(Field::class, $field);
                        }
                    }
                }
            }
        }
    }

    protected function schema(): string
    {
        $schema = __DIR__ . '/../stubs/schema.json';

        return file_get_contents($schema);
    }
}
