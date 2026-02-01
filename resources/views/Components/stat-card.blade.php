@props([
    'col' => 'col-lg-3 col-md-6',
])

<div class="{{ $col }}">
    <div class="card">
        <div class="d-flex align-items-center gap-3">
            <div class="number-icon" style="color: {{ $iconColor }}; background: {{ $iconBg }};">
                <i class="{{ $icon }}"></i>
            </div>

            <div>
                <h1>{{ $value }}</h1>
                <h5>{{ $title }}</h5>
            </div>
        </div>
    </div>
</div>
