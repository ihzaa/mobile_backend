<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class InputGeneral extends Component
{

    public $name, $label, $placeholder, $type, $required, $smallText;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $label, $placeholder, $type, $required = null, $smallText = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->type = $type;
        $this->required = $required;
        $this->smallText = $smallText;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.input-general');
    }
}
