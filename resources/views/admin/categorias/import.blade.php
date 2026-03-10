@extends('admin.layout')

@section('title', 'Importar Categorías')
@section('page-title', 'IMPORTAR CATEGORÍAS')

@section('topbar-actions')
<a href="{{ route('admin.categorias.index') }}" class="abtn abtn-outline">
    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
    </svg>
    Volver
</a>
@endsection

@section('content')

<div class="acard" style="max-width: 700px; margin: 0 auto;">
    <div class="acard-header">
        <span class="acard-title">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
                <polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
            </svg>
            Importar categorías desde CSV
        </span>
    </div>

    <div style="padding: 2rem;">
        <p style="color: var(--text-2); margin-bottom: 1.5rem; line-height: 1.6;">
            Subí un archivo CSV con las categorías que querés importar. El formato debe tener las siguientes columnas:
        </p>

        <div style="background: var(--surface-2); border-radius: var(--radius); padding: 1rem; margin-bottom: 1.5rem;">
            <code style="font-size: 0.8rem; color: var(--lime);">
                name; slug; description; icono_emoji
            </code>
        </div>

        <p style="font-size: 0.85rem; color: var(--text-3); margin-bottom: 2rem;">
            <a href="{{ asset('plantilla_categorias.csv') }}" download style="color: var(--lime);">
                📥 Descargar plantilla de ejemplo
            </a>
        </p>

        <form action="{{ route('admin.categorias.import.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.85rem; color: var(--text-2); margin-bottom: 0.5rem;">
                    Seleccionar archivo CSV
                </label>
                <input type="file" 
                       name="file" 
                       accept=".csv,.xlsx,.xls"
                       required
                       style="
                        width: 100%;
                        padding: 0.75rem;
                        background: var(--surface-2);
                        border: 1px dashed var(--border-solid);
                        border-radius: var(--radius);
                        color: var(--text);
                        font-size: 0.9rem;
                       ">
                @error('file')
                    <p style="color: #ef4444; font-size: 0.8rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="abtn abtn-lime" style="width: 100%;">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
                    <polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
                </svg>
                Importar categorías
            </button>
        </form>
    </div>
</div>

@endsection
