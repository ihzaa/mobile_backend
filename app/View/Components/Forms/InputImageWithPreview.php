<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class InputImageWithPreview extends Component
{
    public $imgPreviewId, $imgSrc, $label, $isRequired, $inputName, $notes;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($imgPreviewId, $label, $isRequired, $inputName, $imgSrc = null, $notes = [])
    {
        $this->imgPreviewId = $imgPreviewId;
        $this->label = $label;
        $this->isRequired = $isRequired;
        $this->inputName = $inputName;
        $this->imgSrc = $imgSrc;
        $this->notes = $notes;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.input-image-with-preview');
    }
}
