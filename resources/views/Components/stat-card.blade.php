@props([
    'col' => 'col-lg-3 col-md-6 col-sm-12 mb-3',
])

<div class="{{ $col }}">
    <div class="card">
        <div class="d-flex align-items-center gap-3">
            <div class="number-icon" style="color: {{ $iconColor }}; background: {{ $iconBg }};">
                <i class="{{ $icon }}"></i>
            </div>

            <div>
                <h2>{{ $value }}</h2>
                <h6>{{ $title }}</h6>
            </div>
        </div>
    </div>
</div>
