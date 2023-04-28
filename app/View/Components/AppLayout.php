<?php

namespace App\View\Components;

use App\Models\Category;
use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $categories = Category::where('nested', '=', 0)->get();
        return view('layouts.app', [
            'categories' => $categories
        ]);
    }
}
