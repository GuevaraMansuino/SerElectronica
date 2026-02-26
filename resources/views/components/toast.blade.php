{{-- Toast Container --}}
<div id="toast-container" class="toast-container"></div>

<style>
.toast-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.toast {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 20px;
    border-radius: var(--radius-lg);
    font-size: 0.9rem;
    font-weight: 500;
    min-width: 280px;
    max-width: 400px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    animation: toastIn 0.3s ease-out;
    color: white;
    position: relative;
}

.toast.toast-exit {
    animation: toastOut 0.3s ease-in forwards;
}

@keyframes toastIn {
    from { transform: translateX(100%); opacity: 0; }
    to   { transform: translateX(0);    opacity: 1; }
}

@keyframes toastOut {
    from { transform: translateX(0);    opacity: 1; }
    to   { transform: translateX(100%); opacity: 0; }
}

@keyframes toastShrink {
    from { width: 100%; }
    to   { width: 0%;   }
}

.toast-success { background: rgba(34,  197, 94,  0.95); border: 1px solid rgba(34,  197, 94,  0.3); }
.toast-error   { background: rgba(239, 68,  68,  0.95); border: 1px solid rgba(239, 68,  68,  0.3); }
.toast-warning { background: rgba(245, 158, 11,  0.95); border: 1px solid rgba(245, 158, 11,  0.3); }
.toast-info    { background: rgba(59,  130, 246, 0.95); border: 1px solid rgba(59,  130, 246, 0.3); }

.toast svg { flex-shrink: 0; width: 20px; height: 20px; }

.toast-close {
    margin-left: auto;
    background: none;
    border: none;
    color: white;
    opacity: 0.7;
    cursor: pointer;
    padding: 0;
    display: flex;
    align-items: center;
}

.toast-close:hover { opacity: 1; }

.toast-progress {
    position: absolute;
    bottom: 0; left: 0;
    height: 3px;
    background: rgba(255,255,255,0.5);
    border-radius: 0 0 var(--radius-lg) var(--radius-lg);
}
</style>

<script>
function showToast(message, type = 'success', duration = 4000) {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const icons = {
        success: '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>',
        error:   '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>',
        warning: '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>',
        info:    '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>'
    };

    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        ${icons[type] || icons.success}
        <span>${message}</span>
        <button class="toast-close" onclick="dismissToast(this.parentElement)">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
        <div class="toast-progress" style="animation: toastShrink ${duration}ms linear forwards;"></div>
    `;

    container.appendChild(toast);

    const timeout = setTimeout(() => dismissToast(toast), duration);

    toast.addEventListener('mouseenter', () => {
        clearTimeout(timeout);
        toast.querySelector('.toast-progress').style.animationPlayState = 'paused';
    });
    toast.addEventListener('mouseleave', () => {
        toast.querySelector('.toast-progress').style.animationPlayState = 'running';
        const prog = toast.querySelector('.toast-progress');
        const pct  = prog.getBoundingClientRect().width / toast.getBoundingClientRect().width;
        setTimeout(() => dismissToast(toast), pct * duration);
    });
}

function dismissToast(toast) {
    if (!toast || toast.classList.contains('toast-exit')) return;
    toast.classList.add('toast-exit');
    setTimeout(() => toast.parentElement?.removeChild(toast), 300);
}
</script>