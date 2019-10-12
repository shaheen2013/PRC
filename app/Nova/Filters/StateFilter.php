<?php

namespace App\Nova\Filters;

use App\Models\State;
use Illuminate\Http\Request;
use DKulyk\Nova\DependentFilter;
use Laravel\Nova\Filters\Filter;

class StateFilter extends DependentFilter
{
    /**
     * Name of filter.
     *
     * @var string
     */
    public $name = 'State';

    /**
     * Attribute name of filter. Also it is key of filter.
     *
     * @var string
     */
    public $attribute = 'code';

    public function options(Request $request, array $filters = [])
    {
        return State::pluck('name', 'code');
    }
}
