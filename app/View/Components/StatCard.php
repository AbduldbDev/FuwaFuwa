<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StatCard extends Component
{
    public function __construct(
        public string $icon,
        public string $iconColor,
        public string $iconBg,
        public string $title,
        public string $value
    ) {}

    public function render()
    {
        return view('components.stat-card');
    }
}
