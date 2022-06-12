<?php

namespace Buildystrap\Builder;

class Renderer
{
    public $sections;

    public function __construct(string $content)
    {
        $this->sections = collect([]);

        $content = json_decode($content) ?? [];

        if (!empty($content->sections)) {
            foreach ($content->sections as $section) {
                if ($section->enabled ?? false) {
                    $item = new Section($section);

                    $this->sections->push($item);
                }
            }
        }
    }

    public function render()
    {
        return view('builder::container')->with('sections', $this->sections)->render();
    }

    public function __toString()
    {
        return $this->render();
    }
}
