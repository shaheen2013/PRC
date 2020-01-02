<?php

namespace Asana\AsanaProject;

use Laravel\Nova\ResourceTool;

class AsanaProject extends ResourceTool
{
    /**
     * Get the displayable name of the resource tool.
     *
     * @return string
     */
    public function name()
    {
        return 'Asana Project';
    }

    /**
     * Get the component name for the resource tool.
     *
     * @return string
     */
    public function component()
    {
        return 'asana-project';
    }
}
