@props(['label' => '', 'title' => '', 'center' => false])

{{--
    Uso:
    @include('components.section-header', [
        'label' => 'Productos',
        'title' => 'CATÁLOGO COMPLETO',
        'center' => false,
    ])
--}}

<div @if($center) style="text-align:center" @endif>
    @if($label)
        <span class="sec-label">{{ $label }}</span>
    @endif
    @if($title)
        <h2 class="sec-title">{{ $title }}</h2>
    @endif
</div>