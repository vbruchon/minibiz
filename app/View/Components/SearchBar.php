<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SearchBar extends Component
{
    public $route;
    public $name;
    public $placeholder;

    public function __construct($route, $name = 'search', $placeholder = 'Search...')
    {
        $this->route = $route;
        $this->name = $name;
        $this->placeholder = $placeholder;
    }

    public function render()
    {
        return view('components.search-bar');
    }
}
