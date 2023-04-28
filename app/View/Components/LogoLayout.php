<?php

namespace App\View\Components;

use Illuminate\View\Component;

class LogoLayout extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $logo = 'https://i.ibb.co/4tNnQ4q/Logopit-1682432874060.png';
        return view('components.logo-layout', [
            'logo' => $logo
        ]);
    }
}
