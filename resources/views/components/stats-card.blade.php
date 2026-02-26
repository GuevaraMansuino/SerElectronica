@props([
    'title' => '',
    'value' => '',
    'icon' => '',
    'trend' => null,
    'trendLabel' => null,
    'color' => 'lime' // lime, success, warning, danger
])

{{--
    Uso:
    @include('components.stats-card', [
        'title' => 'Total Productos',
        'value' => '150',
        'icon' => '📦',
        'trend' => '+12%',
        'trendLabel' => 'vs mes anterior',
        'color' => 'lime'
    ])
--}}

<div class="stats-card stats-card--{{ $color }}">
    <div class="stats-card__icon">
        {{ $icon }}
    </div>
    
    <div class="stats-card__content">
        @if($title)
            <span class="stats-card__title">{{ $title }}</span>
        @endif
        @if($value)
            <span class="stats-card__value">{{ $value }}</span>
        @endif
        
        @if($trend)
            <span class="stats-card__trend">
                <span class="stats-card__trend-icon">
                    @if(str_starts_with($trend, '+'))
                        ↑
                    @else
                        ↓
                    @endif
                </span>
                {{ $trend }}
                @if($trendLabel)
                    <span class="stats-card__trend-label">{{ $trendLabel }}</span>
                @endif
            </span>
        @endif
    </div>
</div>
