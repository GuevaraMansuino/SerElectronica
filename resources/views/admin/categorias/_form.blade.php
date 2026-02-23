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
                {{ $isEdit ? 'Editar: ' . $categoria->nombre : 'Datos de la categoría' }}
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
    btn.innerHTML = '⏳ Guardando...';
    
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
                        Nombre de la categoría <em>*</em>
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
                    <span class="fhint">El slug URL se genera automáticamente: <code id="slug-preview" style="color:var(--lime);font-family:var(--font-mono);font-size:0.72rem;"></code></span>
                </div>

                {{-- Ícono emoji --}}
                <div class="fgroup" style="margin-bottom:1.4rem;">
                    <label class="flabel" for="icono_emoji">
                        Ícono (emoji)
                    </label>
                    <div style="display:flex;gap:0.8rem;align-items:center;">
                        <input type="text"
                               name="icono_emoji"
                               id="icono_emoji"
                               class="finput"
                               value="{{ old('icono_emoji', $categoria->icono_emoji ?? '') }}"
                               placeholder="🔊"
                               maxlength="5"
                               style="max-width:100px;font-size:1.5rem;text-align:center;padding:8px;">

                        {{-- Preview del emoji --}}
                        <div id="emoji-preview"
                             style="width:52px;height:52px;background:var(--lime-dim);border:1px solid rgba(182,255,59,0.2);border-radius:10px;display:grid;place-items:center;font-size:1.8rem;flex-shrink:0;">
                            {{ $categoria->icono_emoji ?? '?' }}
                        </div>
                    </div>
                    <span class="fhint">Aparece en el grid de categorías del inicio. Podés usar cualquier emoji.</span>
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
                        {{ $isEdit ? '💾 Guardar cambios' : '+ Crear categoría' }}
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
                <span class="acard-title">Estadísticas</span>
            </div>
            <div class="acard-body" style="display:flex;flex-direction:column;gap:0.7rem;">
                <div style="text-align:center;padding:1rem 0;">
                    <span style="font-family:var(--font-display);font-size:3rem;color:var(--lime);line-height:1;display:block;">
                        {{ $categoria->productos_count ?? $categoria->productos()->count() }}
                    </span>
                    <span style="font-family:var(--font-mono);font-size:0.62rem;text-transform:uppercase;letter-spacing:0.15em;color:var(--text-3);">
                        productos asociados
                    </span>
                </div>
                <a href="{{ route('admin.productos.index', ['categoria_id' => $categoria->id]) }}"
                   class="abtn abtn-outline"
                   style="justify-content:center;font-size:0.78rem;">
                    Ver productos →
                </a>
                <a href="{{ route('catalogo.index', ['categoria' => $categoria->slug]) }}"
                   target="_blank"
                   class="abtn abtn-outline"
                   style="justify-content:center;font-size:0.78rem;">
                    Ver en el sitio →
                </a>
            </div>
        </div>

        {{-- Eliminar --}}
        @if(($categoria->productos_count ?? $categoria->productos()->count()) === 0)
        <div class="acard" style="border-color:rgba(239,68,68,0.2);">
            <div class="acard-header" style="background:rgba(239,68,68,0.06);">
                <span class="acard-title" style="color:#fca5a5;">Zona de peligro</span>
            </div>
            <div class="acard-body">
                <p style="font-size:0.8rem;color:var(--text-2);margin-bottom:1rem;line-height:1.5;">
                    Eliminar esta categoría es permanente y no se puede deshacer.
                </p>
                <form action="{{ route('admin.categorias.destroy', $categoria) }}"
                      method="POST"
                      id="delete-form-{{ $categoria->id }}"
                      style="width:100%;justify-content:center;">
                    @csrf @method('DELETE')
                    <button type="button" 
                            class="abtn abtn-danger" 
                            style="width:100%;justify-content:center;"
                            data-confirm="¿Eliminar la categoría «{{ addslashes($categoria->nombre) }}» permanentemente?"
                            onclick="confirmDelete(this)">
                        Eliminar categoría
                    </button>
                </form>
            </div>
        </div>
        @endif
        @endif

        {{-- Emojis sugeridos --}}
        <div class="acard">
            <div class="acard-header">
                <span class="acard-title">Emojis sugeridos</span>
            </div>
            <div class="acard-body">
                <div style="display:flex;flex-wrap:wrap;gap:0.4rem;">
                    @foreach(['🔊','🎵','🎸','🎛️','⚡','🔌','📻','🎤','🎧','📦','💡','🔦','📡','🔋','🎚️','🎶','📻','🔈','📱','💻'] as $emoji)
                    <button type="button"
                            class="emoji-pick"
                            onclick="pickEmoji('{{ $emoji }}')"
                            style="width:36px;height:36px;background:var(--bg);border:1px solid var(--border-solid);border-radius:6px;font-size:1.1rem;cursor:pointer;transition:all 0.2s;display:grid;place-items:center;"
                            onmouseover="this.style.borderColor='var(--lime)';this.style.background='var(--lime-dim)'"
                            onmouseout="this.style.borderColor='var(--border-solid)';this.style.background='var(--bg)'">
                        {{ $emoji }}
                    </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
/* ── Slug preview ─────────────────────────────────────────── */
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

/* ── Emoji live preview ───────────────────────────────────── */
const emojiInput   = document.getElementById('icono_emoji');
const emojiPreview = document.getElementById('emoji-preview');

emojiInput.addEventListener('input', () => {
    const val = emojiInput.value.trim();
    emojiPreview.textContent = val || '?';
});

function pickEmoji(emoji) {
    emojiInput.value = emoji;
    emojiPreview.textContent = emoji;
    emojiInput.focus();
}
</script>
@endpush