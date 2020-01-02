<?php

namespace Asana\ProjectDetails;

use Laravel\Nova\ResourceTool;

class ProjectDetails extends ResourceTool
{
    /**
     * Get the displayable name of the resource tool.
     *
     * @return string
     */
    public function name()
    {
        return 'Project Details';
    }

    /**
     * Get the component name for the resource tool.
     *
     * @return string
     */
    public function component()
    {
        return 'project-details';
    }
}
