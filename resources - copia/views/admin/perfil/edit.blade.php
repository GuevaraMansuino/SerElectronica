@extends('admin.layout')

@section('title', 'Editar Perfil')

@section('header_title', 'Mi Perfil')

@push('styles')
    @vite(['resources/css/perfilAdmin.css'])
@endpush

@section('content')
<div class="profile-wrapper">
    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-avatar-large">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="profile-header-text">
                <h2>TU PERFIL DE ADMINISTRADOR</h2>
                <p>Mantené tus credenciales de acceso actualizadas y seguras.</p>
            </div>
        </div>
        
        <div class="profile-body">
            @if (session('success'))
                <div class="profile-alert">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    <div>
                        <strong>¡Éxito!</strong><br>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.perfil.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- INFORMACIÓN BÁSICA -->
                <div class="profile-section-title">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    Información de Contacto
                </div>
                
                <div class="profile-field-group">
                    <div class="profile-input-wrapper">
                        <label for="email" class="profile-label">Correo Electrónico <small>(Para login y recuperación)</small></label>
                        <input type="email" id="email" name="email" class="profile-input" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <span class="profile-form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- CAMBIO DE CONTRASEÑA -->
                <div class="profile-section-title">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0110 0v4"></path></svg>
                    Seguridad
                </div>

                <div class="profile-field-group">
                    <div class="profile-input-wrapper">
                        <label for="current_password" class="profile-label">Contraseña Actual <small>(Requerida solo si vas a cambiar tu contraseña)</small></label>
                        <input type="password" id="current_password" name="current_password" class="profile-input" placeholder="••••••••••">
                        @error('current_password')
                            <span class="profile-form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="profile-grid-2">
                        <div class="profile-input-wrapper">
                            <label for="password" class="profile-label">Nueva Contraseña <small>(Opcional)</small></label>
                            <input type="password" id="password" name="password" class="profile-input" placeholder="Dejar en blanco para no cambiar">
                            @error('password')
                                <span class="profile-form-error">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="profile-input-wrapper">
                            <label for="password_confirmation" class="profile-label">Confirmar Nueva Contraseña</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="profile-input" placeholder="Repite la nueva contraseña">
                        </div>
                    </div>
                </div>

                <div class="profile-actions">
                    <button type="submit" class="profile-btn-save">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
