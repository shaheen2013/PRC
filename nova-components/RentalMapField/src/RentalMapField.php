<?php

namespace Prochamps\RentalMapField;

use Laravel\Nova\Fields\Field;

class RentalMapField extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'RentalMapField';

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

    /**
     * Indicates if the element should be shown on the creation view.
     *
     * @var bool
     */
    public $showOnCreation = false;

    /**
     * Indicates if the element should be shown on the update view.
     *
     * @var bool
     */
    public $showOnUpdate = false;

    public function program(string $program): self
    {
        return $this->withMeta(['program'=>$program]);
    }
}
