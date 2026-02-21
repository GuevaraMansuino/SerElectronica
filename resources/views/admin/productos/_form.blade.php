{{--
    Partial: resources/views/admin/productos/_form.blade.php
    Recibe: $producto (nueva o existente)
--}}

@php
    $isEdit = isset($producto->id) && $producto->id;
    $action = $isEdit
        ? route('admin.productos.update', $producto)
        : route('admin.productos.store');
    $method = $isEdit ? 'PUT' : 'POST';
@endphp

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" id="producto-form">
    @csrf
    @method($method)

    <div style="display:grid;grid-template-columns:1fr 340px;gap:1.8rem;align-items:start;">

        {{-- COLUMNA PRINCIPAL --}}
        <div>
            {{-- Tabs --}}
            <div class="form-tabs">
                <button type="button" class="form-tab active" data-tab="info">Información</button>
                <button type="button" class="form-tab" data-tab="imagen">Imagen</button>
                <button type="button" class="form-tab" data-tab="opciones">Opciones</button>
            </div>

            {{-- Tab: Información --}}
            <div class="tab-panel active" id="tab-info">
                <div class="acard">
                    <div class="acard-header">
                        <span class="acard-title">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                            Datos generales
                        </span>
                    </div>
                    <div class="acard-body">
                        <div class="form-grid">

                            {{-- Nombre --}}
                            <div class="fgroup form-full">
                                <label class="flabel" for="nombre">Nombre del producto <em>*</em></label>
                                <input type="text"
                                       name="nombre"
                                       id="nombre"
                                       class="finput"
                                       value="{{ old('nombre', $producto->nombre ?? '') }}"
                                       placeholder='Ej: Parlante Activo 15" JBL PRX715'
                                       required
                                       maxlength="200">
                            </div>

                            {{-- Categoría --}}
                            <div class="fgroup">
                                <label class="flabel" for="categoria_id">Categoría <em>*</em></label>
                                <select name="categoria_id"
                                        id="categoria_id"
                                        class="fselect"
                                        required>
                                    <option value="" disabled selected>
                                        — Seleccioná una categoría —
                                    </option>
                                    @foreach($categorias as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ (isset($producto->category_id) && $producto->category_id == $cat->id) ? 'selected' : '' }}>
                                        {{ $cat->nombre }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Precio --}}
                            <div class="fgroup">
                                <label class="flabel" for="precio">Precio en ARS <em>*</em></label>
                                <div style="position:relative;">
                                    <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-3);font-family:var(--font-display);font-size:1rem;">$</span>
                                    <input type="number"
                                           name="precio"
                                           id="precio"
                                           class="finput"
                                           value="{{ old('precio', $producto->precio ?? '') }}"
                                           placeholder="0"
                                           min="0"
                                           step="100"
                                           style="padding-left:26px;"
                                           required>
                                </div>
                            </div>

                            {{-- Marca --}}
                            <div class="fgroup">
                                <label class="flabel" for="marca">Marca</label>
                                <input type="text"
                                       name="marca"
                                       id="marca"
                                       class="finput"
                                       value="{{ old('marca', $producto->marca ?? '') }}"
                                       placeholder="Ej: JBL, Pioneer, Yamaha, Sony">
                            </div>

                            {{-- Modelo --}}
                            <div class="fgroup">
                                <label class="flabel" for="modelo">Modelo</label>
                                <input type="text"
                                       name="modelo"
                                       id="modelo"
                                       class="finput"
                                       value="{{ old('modelo', $producto->modelo ?? '') }}"
                                       placeholder="Ej: PRX715, DJM-900NXS2">
                            </div>

                            {{-- Descripción --}}
                            <div class="fgroup form-full">
                                <label class="flabel" for="descripcion">
                                    Descripción <em>*</em>
                                </label>
                                <textarea name="descripcion"
                                          id="descripcion"
                                          class="ftextarea"
                                          rows="6"
                                          placeholder="Describí el producto: características técnicas, uso recomendado, potencia, conectividad..."
                                          required>{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Tab: Imagen --}}
            <div class="tab-panel" id="tab-imagen">
                <div class="acard">
                    <div class="acard-header">
                        <span class="acard-title">Imagen del producto</span>
                    </div>
                    <div class="acard-body">
                        {{-- Dropzone styled area --}}
                        <div class="img-dropzone"
                             id="producto-dz"
                             onclick="document.getElementById('producto-img-input').click()"
                             ondragover="event.preventDefault();this.style.borderColor='var(--lime)'"
                             ondragleave="this.style.borderColor='var(--border-solid)'"
                             ondrop="handleProductoDrop(event)">
                            <input type="file"
                                   name="imagen"
                                   id="producto-img-input"
                                   accept="image/jpeg,image/png,image/webp"
                                   style="display:none"
                                   onchange="handleProductoFile(this)">
                            <div style="font-size:1.8rem;margin-bottom:0.4rem;">🖼️</div>
                            <p style="font-size:0.84rem;color:var(--text-2);">Hacé clic o arrastrá una imagen</p>
                            <p style="font-size:0.72rem;color:var(--text-3);margin-top:0.2rem;">JPG, PNG, WEBP · máx. 2 MB</p>
                        </div>

                        {{-- Preview --}}
                        @if($isEdit && $producto->imagen)
                        <div id="producto-img-preview" style="margin-top:0.8rem;border-radius:var(--radius-lg);overflow:hidden;border:1px solid var(--border-solid);">
                            <img src="{{ asset('storage/' . $producto->imagen) }}"
                                 alt="Imagen actual"
                                 style="width:100%;max-height:200px;object-fit:cover;display:block;">
                        </div>
                        @else
                        <div id="producto-img-preview"></div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Tab: Opciones --}}
            <div class="tab-panel" id="tab-opciones">
                <div class="acard">
                    <div class="acard-header">
                        <span class="acard-title">Opciones adicionales</span>
                    </div>
                    <div class="acard-body" style="display:flex;flex-direction:column;gap:1rem;">
                        <label class="acheckbox">
                            <input type="checkbox" name="is_new" value="1" {{ old('is_new', $producto->is_new ?? false) ? 'checked' : '' }}>
                            <span class="acheckbox-mark">✓</span>
                            <span>Producto nuevo</span>
                        </label>
                        <label class="acheckbox">
                            <input type="checkbox" name="destacado" value="1" {{ old('destacado', $producto->destacado ?? false) ? 'checked' : '' }}>
                            <span class="acheckbox-mark">✓</span>
                            <span>Producto destacado</span>
                        </label>
                        <label class="acheckbox">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $producto->is_active ?? true) ? 'checked' : '' }}>
                            <span class="acheckbox-mark">✓</span>
                            <span>Activo (visible en el catálogo)</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- COLUMNA LATERAL --}}
        <div style="display:flex;flex-direction:column;gap:1.5rem;">
            <div class="acard">
                <div class="acard-header">
                    <span class="acard-title">Publicar</span>
                </div>
                <div class="acard-body" style="display:flex;flex-direction:column;gap:0.7rem;">
                    <button type="submit" class="abtn abtn-lime" style="justify-content:center;width:100%;padding:11px;">
                        {{ $isEdit ? '💾 Guardar cambios' : '+ Crear producto' }}
                    </button>
                    <a href="{{ route('admin.productos.index') }}" class="abtn abtn-outline" style="justify-content:center;">
                        Cancelar
                    </a>
                </div>
            </div>

            @if($isEdit)
            <div class="acard" style="border-color:var(--danger);">
                <div class="acard-header" style="border-color:var(--danger);">
                    <span class="acard-title" style="color:var(--danger);">Zona de peligro</span>
                </div>
                <div class="acard-body">
                    <p style="font-size:0.8rem;color:var(--text-2);margin-bottom:0.8rem;">
                        Eliminar este producto permanentemente.
                    </p>
                    <button type="button"
                            class="abtn abtn-danger"
                            style="width:100%;justify-content:center;"
                            onclick="if(confirm('¿Eliminar este producto permanentemente?')) { fetch('{{ route('admin.productos.destroy', $producto) }}', { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } }).then(() => window.location = '{{ route('admin.productos.index') }}'); }">
                        Eliminar producto
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
</form>

<style>
.img-dropzone {
    border: 2px dashed var(--border-solid);
    border-radius: var(--radius-lg);
    padding: 1.8rem;
    text-align: center;
    cursor: pointer;
    background: var(--bg);
    transition: all var(--t);
}
.img-dropzone:hover {
    border-color: var(--lime);
}
</style>

@push('scripts')
<script>
/* ── Tabs ─────────────────────────────────────────────── */
document.querySelectorAll('.form-tab').forEach(tab => {
    tab.addEventListener('click', () => {
        document.querySelectorAll('.form-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
        tab.classList.add('active');
        document.getElementById('tab-' + tab.dataset.tab).classList.add('active');
    });
});

/* ── Imagen dropzone ──────────────────────────────────── */
function handleProductoFile(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('producto-img-preview').innerHTML = `
            <div style="border-radius:var(--radius-lg);overflow:hidden;border:1px solid var(--border-solid);margin-top:0.8rem;">
                <img src="${e.target.result}" style="width:100%;max-height:200px;object-fit:cover;display:block;">
            </div>`;
    };
    reader.readAsDataURL(input.files[0]);
}

function handleProductoDrop(e) {
    e.preventDefault();
    document.getElementById('producto-dz').style.borderColor = 'var(--border-solid)';
    const file = e.dataTransfer.files[0];
    if (!file || !file.type.startsWith('image/')) return;
    const input = document.getElementById('producto-img-input');
    const dt = new DataTransfer();
    dt.items.add(file);
    input.files = dt.files;
    handleProductoFile(input);
}
</script>
@endpush
