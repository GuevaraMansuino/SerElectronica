function confirmDelete(button) {
    const message = button.dataset.confirm;
    const form    = button.closest('form');
    _openConfirm('Confirmar eliminación', message, () => form.submit());
}

function confirmAction(title, message, onConfirm) {
    _openConfirm(title, message, onConfirm);
}

function _openConfirm(title, message, onConfirm) {
    const modal      = document.getElementById('confirmModal');
    const titleEl    = document.getElementById('confirmModalTitle');
    const messageEl  = document.getElementById('confirmModalMessage');
    const confirmBtn = document.getElementById('confirmModalConfirm');
    const cancelBtn  = document.getElementById('confirmModalCancel');

    titleEl.textContent   = title;
    messageEl.textContent = message;
    modal.classList.add('active');

    const close = () => {
        modal.classList.remove('active');
        confirmBtn.removeEventListener('click', handleConfirm);
        cancelBtn.removeEventListener('click', handleCancel);
        document.removeEventListener('keydown', handleEscape);
    };

    const handleConfirm = () => { close(); onConfirm?.(); };
    const handleCancel  = () => close();
    const handleEscape  = e => { if (e.key === 'Escape') close(); };

    confirmBtn.addEventListener('click', handleConfirm);
    cancelBtn.addEventListener('click',  handleCancel);
    document.addEventListener('keydown', handleEscape);
}

// Interceptar forms con data-confirm
document.addEventListener('DOMContentLoaded', () => {
    document.addEventListener('submit', function(e) {
        const form = e.target;
        const msg  = form.dataset.confirm;
        if (!msg) return;
        e.preventDefault();
        const title = form.dataset.confirmTitle || 'Confirmar acción';
        confirmAction(title, msg, () => form.submit());
    });
});