<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdminLayout extends Component
{
    public $title;

    public function __construct($title = 'لوحة التحكم')
    {
        $this->title = $title;
    }

    public function render()
    {
        return view('components.admin-layout');
    }
}
