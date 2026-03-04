<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — SER Electrónica</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="/LogoPagina.svg">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800&family=Barlow:wght@300;400;500;600&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/admin.css'])
    @stack('styles')
</head>
<body>

{{-- ================================================================
     SIDEBAR
================================================================ --}}
<aside class="sidebar" role="navigation" aria-label="Panel de administración">

    <a href="{{ route('admin.dashboard') }}" class="sidebar__logo">
        <div class="s-logo-hex"><img src="{{ asset('LogoPagina.svg') }}" alt="SER" style="width:100%;height:100%;object-fit:contain;"></div>
        <div>
            <span class="sidebar__brand">SER <em>ELECTRÓNICA</em></span>
            <span class="sidebar__brand-sub">Panel Admin</span>
        </div>
    </a>

    <nav class="sidebar__nav">
        <span class="nav-group-label">General</span>
        <a href="{{ route('admin.dashboard') }}"
           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            Dashboard
        </a>

        <span class="nav-group-label">Catálogo</span>
        <a href="{{ route('admin.categorias.index') }}"
           class="nav-link {{ request()->routeIs('admin.categorias.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 7h4l2-4h6l2 4h4"/><path d="M5 21h14"/><line x1="12" y1="7" x2="12" y2="21"/></svg>
            Categorías
        </a>
        <a href="{{ route('admin.productos.index') }}"
           class="nav-link {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="3" width="6" height="6"/><rect x="9" y="3" width="6" height="6"/><rect x="16" y="3" width="6" height="6"/><rect x="2" y="10" width="6" height="11"/><rect x="9" y="10" width="13" height="11"/></svg>
            Productos
        </a>
        <a href="{{ route('admin.promociones.index') }}"
           class="nav-link {{ request()->routeIs('admin.promociones.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            Promociones
        </a>

        <span class="nav-group-label">Sistema</span>
        <a href="{{ route('home') }}" target="_blank" class="nav-link" rel="noopener">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            Ver sitio público
        </a>
    </nav>

    <div class="sidebar__footer">
        {{-- Logo watermark --}}
        <div style="text-align:center;padding:0.5rem 0;border-bottom:1px solid var(--border-solid);margin-bottom:0.8rem;">
            <img src="{{ asset('ggm-logo.svg') }}" alt="GGM" style="width:60px;height:auto;opacity:0.7;align-self:center;margin:0 auto;">
            <div style="font-size:0.65rem;color:var(--text-3);margin-top:0.3rem;">Desarrollador Web Gerónimo Guevara Mansuino</div>
        </div>
        <div class="sidebar__user">
            <div class="user-avatar" aria-hidden="true">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
            <div>
                <div class="user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
                <div class="user-role">Administrador</div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="sidebar__logout">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Cerrar sesión
            </button>
        </form>
    </div>
</aside>

{{-- ================================================================
    MAIN
================================================================ --}}
<div class="admin-main">

    {{-- Topbar --}}
    <header class="topbar">
        <h1 class="topbar__title">@yield('page-title', 'Dashboard')</h1>
        <div class="topbar__actions">@yield('topbar-actions')</div>
    </header>

    {{-- Content --}}
    <div class="admin-content">

        {{-- Toast Container --}}
        <div id="toast-container" class="toast-container"></div>

        {{-- Flash Messages as Toasts --}}
        @if(session('success'))
            <script>document.addEventListener('DOMContentLoaded', function() { showToast('{{ session("success") }}', 'success'); });</script>
        @endif

        @if(session('error'))
            <script>document.addEventListener('DOMContentLoaded', function() { showToast('{{ session("error") }}', 'error'); });</script>
        @endif

        @yield('content')
    </div>
</div>



<script>
function showToast(message, type = 'success', duration = 4000) {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    
    const icons = {
        success: '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>',
        error: '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>',
        warning: '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>',
        info: '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>'
    };
    
    toast.innerHTML = `
        ${icons[type] || icons.success}
        <span>${message}</span>
        <button class="toast-close" onclick="dismissToast(this.parentElement)">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
        <div class="toast-progress" style="width: 100%; animation: shrink ${duration}ms linear forwards;"></div>
    `;
    
    container.appendChild(toast);
    
    // Auto dismiss
    const timeout = setTimeout(() => {
        dismissToast(toast);
    }, duration);
    
    // Pause on hover
    toast.addEventListener('mouseenter', () => {
        clearTimeout(timeout);
        toast.querySelector('.toast-progress').style.animationPlayState = 'paused';
    });
    
    toast.addEventListener('mouseleave', () => {
        const remaining = toast.querySelector('.toast-progress').getBoundingClientRect().width;
        const total = toast.getBoundingClientRect().width;
        const percent = (remaining / total) * duration;
        const newTimeout = setTimeout(() => {
            dismissToast(toast);
        }, percent);
        toast.querySelector('.toast-progress').style.animationPlayState = 'running';
    });
}

function dismissToast(toast) {
    if (toast.classList.contains('toast-exit')) return;
    toast.classList.add('toast-exit');
    setTimeout(() => {
        if (toast.parentElement) {
            toast.parentElement.removeChild(toast);
        }
    }, 300);
}

// Custom confirm function
function confirmDelete(button) {
    const message = button.dataset.confirm;
    const form = button.closest('form');
    
    const modal = document.getElementById('confirmModal');
    const titleEl = document.getElementById('confirmModalTitle');
    const messageEl = document.getElementById('confirmModalMessage');
    const confirmBtn = document.getElementById('confirmModalConfirm');
    const cancelBtn = document.getElementById('confirmModalCancel');
    
    titleEl.textContent = 'Confirmar eliminación';
    messageEl.textContent = message;
    
    modal.classList.add('active');
    
    // Clean up previous event listeners
    const newConfirmBtn = confirmBtn.cloneNode(true);
    const newCancelBtn = cancelBtn.cloneNode(true);
    confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
    cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);
    
    newConfirmBtn.addEventListener('click', () => {
        modal.classList.remove('active');
        form.submit();
    });
    
    newCancelBtn.addEventListener('click', () => {
        modal.classList.remove('active');
    });
}

// Confirm Modal Functions
let confirmCallback = null;

function confirmAction(title, message, onConfirm) {
    const modal = document.getElementById('confirmModal');
    const titleEl = document.getElementById('confirmModalTitle');
    const messageEl = document.getElementById('confirmModalMessage');
    const confirmBtn = document.getElementById('confirmModalConfirm');
    const cancelBtn = document.getElementById('confirmModalCancel');
    
    titleEl.textContent = title;
    messageEl.textContent = message;
    confirmCallback = onConfirm;
    
    modal.classList.add('active');
    
    // Handle button clicks
    const handleConfirm = () => {
        modal.classList.remove('active');
        if (confirmCallback) {
            confirmCallback();
            confirmCallback = null;
        }
        cleanup();
    };
    
    const handleCancel = () => {
        modal.classList.remove('active');
        confirmCallback = null;
        cleanup();
    };
    
    const cleanup = () => {
        confirmBtn.removeEventListener('click', handleConfirm);
        cancelBtn.removeEventListener('click', handleCancel);
        document.removeEventListener('keydown', handleEscape);
    };
    
    const handleEscape = (e) => {
        if (e.key === 'Escape') {
            handleCancel();
        }
    };
    
    confirmBtn.addEventListener('click', handleConfirm);
    cancelBtn.addEventListener('click', handleCancel);
    document.addEventListener('keydown', handleEscape);
}

// Override confirm for forms
document.addEventListener('submit', function(e) {
    const form = e.target;
    const confirmMsg = form.dataset.confirm || form.getAttribute('data-confirm');
    if (confirmMsg) {
        e.preventDefault();
        const title = form.dataset.confirmTitle || 'Confirmar acción';
        const message = confirmMsg;
        confirmAction(title, message, () => {
            // Submit the form normally
            const methodInput = form.querySelector('input[name="_method"]');
            if (methodInput) {
                // Use method spoofing
                const tempForm = document.createElement('form');
                tempForm.action = form.action;
                tempForm.method = 'POST';
                
                // Copy all inputs from original form
                Array.from(form.querySelectorAll('input, select, textarea')).forEach(input => {
                    const clone = input.cloneNode(true);
                    tempForm.appendChild(clone);
                });
                
                document.body.appendChild(tempForm);
                tempForm.submit();
            } else {
                form.submit();
            }
        });
    }
});

// Handle onclick confirm for links and buttons
document.addEventListener('click', function(e) {
    const target = e.target.closest('[data-confirm]');
    if (target && !target.hasAttribute('data-confirm-processed')) {
        e.preventDefault();
        target.setAttribute('data-confirm-processed', 'true');
        
        const title = target.dataset.confirmTitle || 'Confirmar acción';
        const message = target.dataset.confirm;
        
        confirmAction(title, message, () => {
            // If it's a link, navigate
            if (target.tagName === 'A') {
                window.location.href = target.href;
            } else if (target.onclick) {
                target.onclick();
            } else if (target.type === 'submit') {
                target.form.submit();
            }
        });
    }
});

// Add shrink animation
const style = document.createElement('style');
style.textContent = `
    @keyframes shrink {
        from { width: 100%; }
        to { width: 0%; }
    }
`;
document.head.appendChild(style);

// Handle 419 Page Expired - redirect to login
document.addEventListener('ajaxError', function(event) {
    if (event.detail && event.detail.status === 419) {
        window.location.href = '/login?expired=1';
    }
});

// Global fetch error handler for 419
const originalFetch = window.fetch;
window.fetch = function(...args) {
    return originalFetch.apply(this, args).then(response => {
        if (response.status === 419) {
            window.location.href = '/login?expired=1';
        }
        return response;
    });
};

// Intercept all form submissions to add CSRF token and handle 419
document.addEventListener('submit', function(e) {
    const form = e.target;
    if (form.method && form.method.toLowerCase() === 'post') {
        // Check if form has CSRF token
        const csrfInput = form.querySelector('input[name="_token"]');
        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        
        if (!csrfInput && csrfMeta) {
            // Add CSRF token if missing
            const token = document.createElement('input');
            token.type = 'hidden';
            token.name = '_token';
            token.value = csrfMeta.content;
            form.insertBefore(token, form.firstChild);
        }
    }
});

// Also intercept XMLHttpRequest for AJAX
const originalXHROpen = XMLHttpRequest.prototype.open;
XMLHttpRequest.prototype.open = function(method, url) {
    this.addEventListener('load', function() {
        if (this.status === 419) {
            window.location.href = '/login?expired=1';
        }
    });
    return originalXHROpen.apply(this, arguments);
};
</script>

{{-- Confirm Modal --}}
<div class="confirm-modal-overlay" id="confirmModal">
    <div class="confirm-modal">
        <h3 class="confirm-modal__title" id="confirmModalTitle">Confirmar acción</h3>
        <p class="confirm-modal__message" id="confirmModalMessage">¿Estás seguro de que deseas continuar?</p>
        <div class="confirm-modal__actions">
            <button type="button" class="confirm-modal__btn confirm-modal__btn--cancel" id="confirmModalCancel">Cancelar</button>
            <button type="button" class="confirm-modal__btn confirm-modal__btn--danger" id="confirmModalConfirm">Eliminar</button>
        </div>
    </div>
</div>

@stack('scripts')
</body>
</html>