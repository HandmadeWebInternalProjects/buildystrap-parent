<?php

namespace Buildystrap\View\Directives;

class ExampleDirective
{
    /**
     * Invoke the @example directive.
     *
     * @param  string $expression
     * @return string
     */
    public function __invoke($expression)
    {
        return sprintf("<?php echo %s; ?>", $expression);
    }
}
