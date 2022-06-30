<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder;
use Buildystrap\Builder\Extends\Module;

class GlobalModule extends Module
{
    protected static function blueprint(): array
    {
        return [
            'icon' => 'fa-solid fa-anchor',
            'fields' => [
                'id' => [
                    'type' => 'text-field',
                ],
            ],
        ];
    }

    public function render(): string
    {
        if ($global_id = $this->fields()->get('id')) {
            $global_id = $global_id->value();

            if ($module = Builder::getGlobalModule($global_id)) {
                return $module->render();
            }
        }

        return '';
    }

    protected function augment(): void
    {
    }
}
