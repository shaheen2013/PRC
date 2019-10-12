<?php

namespace Prochamps\CommunityListDashboard;

use Laravel\Nova\Card;
use Laravel\Nova\Filters\Filter;

class CommunityListDashboard extends Card
{
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = 'full';

    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'community-list-dashboard';
    }
}
