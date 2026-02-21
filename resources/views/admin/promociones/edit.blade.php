{{-- ============================================================
   ARCHIVO: resources/views/admin/promociones/edit.blade.php
============================================================ --}}
@extends('admin.layout')

@section('title', 'Editar: ' . $promo->titulo)
@section('page-title', 'EDITAR PROMOCIÓN')

@section('topbar-actions')
<a href="{{ route('admin.promociones.index') }}" class="abtn abtn-outline">
    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
        <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
    </svg>
    Volver
</a>
@endsection

@section('content')
@include('admin.promociones._form', ['promo' => $promo])
@endsection