@extends('admin.layout')

@section('title', 'Editar: ' . $producto->nombre)
@section('page-title', 'EDITAR PRODUCTO')

@section('topbar-actions')
<div style="display:flex;gap:0.6rem;align-items:center;">
    <a href="{{ route('producto.show', $producto->slug) }}"
       target="_blank"
       class="abtn abtn-outline">
        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/>
            <polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/>
        </svg>
        Ver en sitio
    </a>
    <a href="{{ route('admin.productos.index') }}" class="abtn abtn-outline">
        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
        </svg>
        Volver
    </a>
</div>
@endsection

@section('content')
@include('admin.productos._form', ['producto' => $producto])
@endsection