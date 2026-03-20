{{--
    Partial: resources/views/admin/categorias/_form.blade.php
    Recibe: $categoria (nueva o existente)
--}}

@php
    $isEdit = isset($categoria->id) && $categoria->id;
    $action = $isEdit
        ? route('admin.categorias.update', $categoria)
        : route('admin.categorias.store');
    $method = $isEdit ? 'PUT' : 'POST';
@endphp

<div style="display:grid;grid-template-columns:1fr 300px;gap:1.5rem;align-items:start;">

    {{-- Formulario --}}
    <div class="acard">
        <div class="acard-header">
            <span class="acard-title">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 7h4l2-4h6l2 4h4"/><path d="M5 21h14"/><line x1="12" y1="7" x2="12" y2="21"/>
                </svg>
                {{ $isEdit ? 'Editar: ' . $categoria->nombre : 'Datos de la categorÃ­a' }}
            </span>
        </div>
        <div class="acard-body">
            <form action="{{ $action }}" method="POST" id="cat-form">
                @csrf
                @method($method)
                <script>
document.getElementById('cat-form').addEventListener('submit', function(e) {
    e.preventDefault();
    var form = this;
    var btn = form.querySelector('button[type=submit]');
    var originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = 'â³ Guardando...';
    
    fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'text/html'
        }
    })
    .then(function(response) {
        if (response.redirected) {
            window.location = response.url;
        } else {
            return response.text();
        }
    })
    .then(function(html) {
        if (html) {
            document.body.innerHTML = html;
        }
    })
    .catch(function(error) {
        alert('Error: ' + error.message);
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
});
</script>

                {{-- Nombre --}}
                <div class="fgroup" style="margin-bottom:1.4rem;">
                    <label class="flabel" for="nombre">
                        Nombre de la categorÃ­a <em>*</em>
                    </label>
                    <input type="text"
                           name="nombre"
                           id="nombre"
                           class="finput"
                           value="{{ old('nombre', $categoria->nombre ?? '') }}"
                           placeholder="Ej: Altavoces Activos, Amplificadores, Cables..."
                           required
                           maxlength="100"
                           autofocus>
                    @error('nombre')
                        <span class="ferror">{{ $message }}</span>
                    @enderror
                    <span class="fhint">El slug URL se genera automÃ¡ticamente: <code id="slug-preview" style="color:var(--lime);font-family:var(--font-mono);font-size:0.72rem;"></code></span>
                </div>


                {{-- Slug personalizado (solo edit) --}}
                @if($isEdit)
                <div class="fgroup" style="margin-bottom:1.4rem;">
                    <label class="flabel">Slug URL (No editable)</label>
                    <div style="background:var(--surface-2);padding:10px 14px;border-radius:var(--radius);border:1px solid var(--border-solid);color:var(--text-3);font-family:var(--font-mono);font-size:0.85rem;">
                        /{{ $categoria->slug }}
                    </div>
                    <span class="fhint">El slug no se puede modificar para evitar romper enlaces existentes.</span>
                </div>
                @endif

                <div class="form-actions">
                    <button type="submit" class="abtn abtn-lime" style="padding:11px 28px;">
                        {{ $isEdit ? 'ðŸ’¾ Guardar cambios' : '+ Crear categorÃ­a' }}
                    </button>
                    <a href="{{ route('admin.categorias.index') }}" class="abtn abtn-outline">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Panel lateral --}}
    <div style="display:flex;flex-direction:column;gap:1.2rem;">

        {{-- Info --}}
        @if($isEdit)
        <div class="acard">
            <div class="acard-header">
                <span class="acard-title">EstadÃ­sticas</span>
            </div>
            <div class="acard-body" style="display:flex;flex-direction:column;gap:0.7rem;">
                <div style="text-align:center;padding:1rem 0;">
                    <span style="font-family:var(--font-display);font-size:3rem;color:var(--lime);line-height:1;display:block;">
                        {{ $categoria->products_count ?? $categoria->productos()->count() }}
                    </span>
                    <span style="font-family:var(--font-mono);font-size:0.62rem;text-transform:uppercase;letter-spacing:0.15em;color:var(--text-3);">
                        productos asociados
                    </span>
                </div>
                <a href="{{ route('admin.productos.index', ['categoria_id' => $categoria->id]) }}"
                   class="abtn abtn-outline"
                   style="justify-content:center;font-size:0.78rem;">
                    Ver productos â†’
                </a>
                <a href="{{ route('catalogo.index', ['categoria' => $categoria->slug]) }}"
                   target="_blank"
                   class="abtn abtn-outline"
                   style="justify-content:center;font-size:0.78rem;">
                    Ver en el sitio â†’
                </a>
            </div>
        </div>

        {{-- Eliminar --}}
        @if(($categoria->products_count ?? $categoria->productos()->count()) === 0)
        <div class="acard" style="border-color:rgba(239,68,68,0.2);">
            <div class="acard-header" style="background:rgba(239,68,68,0.06);">
                <span class="acard-title" style="color:#fca5a5;">Zona de peligro</span>
            </div>
            <div class="acard-body">
                <p style="font-size:0.8rem;color:var(--text-2);margin-bottom:1rem;line-height:1.5;">
                    Eliminar esta categorÃ­a es permanente y no se puede deshacer.
                </p>
                <form action="{{ route('admin.categorias.destroy', $categoria) }}"
                      method="POST"
                      id="delete-form-{{ $categoria->id }}"
                      style="width:100%;justify-content:center;">
                    @csrf @method('DELETE')
                    <button type="button" 
                            class="abtn abtn-danger" 
                            style="width:100%;justify-content:center;"
                            data-confirm="Â¿Eliminar la categorÃ­a Â«{{ addslashes($categoria->nombre) }}Â» permanentemente?"
                            onclick="confirmDelete(this)">
                        Eliminar categorÃ­a
                    </button>
                </form>
            </div>
        </div>
        @endif
        @endif

    </div>
</div>

@push('scripts')
<script>
/* â”€â”€ Slug preview â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
const nombreInput   = document.getElementById('nombre');
const slugPreview   = document.getElementById('slug-preview');
const slugInput     = document.getElementById('slug');

function toSlug(str) {
    return str
        .toLowerCase()
        .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
        .replace(/[^a-z0-9\s-]/g, '')
        .trim()
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');
}

nombreInput.addEventListener('input', () => {
    const s = toSlug(nombreInput.value);
    if (slugPreview) slugPreview.textContent = s ? '/' + s : '';
    if (slugInput && !slugInput.dataset.touched) slugInput.value = s;
});

if (slugInput) {
    slugInput.addEventListener('input', () => slugInput.dataset.touched = 'yes');
}

// Init
if (slugPreview && nombreInput.value) {
    slugPreview.textContent = '/' + toSlug(nombreInput.value);
}
</script>
@endpush