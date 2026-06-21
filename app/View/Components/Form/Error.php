<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Error extends Component
{
    public function __construct(
        public string $field
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.form.error');
    }
}
