{{--
    Partial: resources/views/admin/promociones/_form.blade.php
    Recibe: $promo (nueva o existente)
--}}

@php
    $isEdit = isset($promo->id) && $promo->id;
    $action = $isEdit
        ? route('admin.promociones.update', $promo)
        : route('admin.promociones.store');
    $method = $isEdit ? 'PUT' : 'POST';
@endphp

@push('styles')
<style>
/* Preview card de la promo */
.promo-preview {
    background: var(--bg);
    border: 1px solid var(--border-solid);
    border-radius: var(--radius-lg);
    padding: 2rem;
    position: relative;
    overflow: hidden;
    transition: border-color var(--t);
}

.promo-preview::after {
    content: '';
    position: absolute;
    top: -40px; right: -40px;
    width: 140px; height: 140px;
    background: radial-gradient(circle, rgba(182,255,59,0.08) 0%, transparent 60%);
    pointer-events: none;
}

.promo-preview__tag {
    display: inline-block;
    background: var(--lime);
    color: var(--bg);
    font-family: var(--font-mono);
    font-size: 0.6rem;
    font-weight: 500;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    padding: 3px 10px;
    border-radius: 3px;
    margin-bottom: 0.8rem;
}

.promo-preview__title {
    font-family: var(--font-display);
    font-size: 1.6rem;
    font-weight: 800;
    color: var(--text);
    letter-spacing: 0.04em;
    line-height: 1.1;
    margin-bottom: 0.6rem;
}

.promo-preview__desc {
    font-size: 0.84rem;
    color: var(--text-2);
    line-height: 1.6;
    margin-bottom: 1.2rem;
}

.promo-preview__label {
    position: absolute;
    top: 8px; right: 8px;
    font-family: var(--font-mono);
    font-size: 0.58rem;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    color: var(--text-3);
    background: var(--surface);
    padding: 2px 7px;
    border-radius: 3px;
    border: 1px solid var(--border-solid);
}
</style>
@endpush

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" id="promo-form">
    @csrf
    @method($method)

    <div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start;">

        {{-- ── FORMULARIO ──────────────────────────────── --}}
        <div class="acard">
            <div class="acard-header">
                <span class="acard-title">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                    </svg>
                    {{ $isEdit ? 'Editar: ' . $promo->titulo : 'Datos de la promoción' }}
                </span>
            </div>
            <div class="acard-body">

                {{-- Título --}}
                <div class="fgroup" style="margin-bottom:1.3rem;">
                    <label class="flabel" for="titulo">
                        Título de la promoción <em>*</em>
                    </label>
                    <input type="text"
                           name="titulo"
                           id="titulo"
                           class="finput"
                           value="{{ old('titulo', $promo->titulo ?? '') }}"
                           placeholder="Ej: Verano en audio – 20% OFF en altavoces"
                           required
                           maxlength="120"
                           oninput="updatePreview()">
                    @error('titulo')
                        <span class="ferror">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Descripción --}}
                <div class="fgroup" style="margin-bottom:1.3rem;">
                    <label class="flabel" for="descripcion">
                        Descripción <em>*</em>
                    </label>
                    <textarea name="descripcion"
                              id="descripcion"
                              class="ftextarea"
                              rows="4"
                              placeholder="Describí la promo: productos incluidos, condiciones, cómo aprovecharla..."
                              required
                              oninput="updatePreview()">{{ old('descripcion', $promo->descripcion ?? '') }}</textarea>
                    @error('descripcion')
                        <span class="ferror">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Fila: fecha de inicio + fecha de vencimiento + estado --}}
                <div class="form-grid" style="margin-bottom:1.3rem;">
                    <div class="fgroup">
                        <label class="flabel" for="fecha_inicio">
                            Fecha de inicio
                        </label>
                        <input type="date"
                               name="fecha_inicio"
                               id="fecha_inicio"
                               class="finput"
                               value="{{ old('fecha_inicio', isset($promo->fecha_inicio) ? $promo->fecha_inicio->format('Y-m-d') : '') }}"
                               min="{{ now()->format('Y-m-d') }}">
                        <span class="fhint">Dejar vacío = comienza inmediatamente</span>
                    </div>

                    <div class="fgroup">
                        <label class="flabel" for="fecha_fin">
                            Fecha de vencimiento
                        </label>
                        <input type="date"
                               name="fecha_fin"
                               id="fecha_fin"
                               class="finput"
                               value="{{ old('fecha_fin', isset($promo->fecha_fin) ? $promo->fecha_fin->format('Y-m-d') : '') }}"
                               min="{{ now()->format('Y-m-d') }}">
                        <span class="fhint">Dejar vacío = sin vencimiento automático</span>
                    </div>

                    <div class="fgroup" style="justify-content:flex-end;">
                        <label class="flabel">Estado inicial</label>
                        <label style="display:flex;align-items:center;gap:0.7rem;cursor:pointer;background:var(--bg);border:1px solid var(--border-solid);border-radius:var(--radius);padding:10px 14px;transition:all var(--t);"
                               id="activa-label">
                            <input type="checkbox"
                                   name="activa"
                                   id="activa"
                                   value="1"
                                   {{ old('activa', $promo->activa ?? true) ? 'checked' : '' }}
                                   style="accent-color:var(--lime);width:18px;height:18px;"
                                   onchange="this.closest('label').style.borderColor = this.checked ? 'var(--lime)' : 'var(--border-solid)'">
                            <div>
                                <span style="font-size:0.86rem;font-weight:600;color:var(--text);display:block;">Activa</span>
                                <span style="font-size:0.72rem;color:var(--text-3);">Visible en el sitio</span>
                            </div>
                        </label>
                        @error('activa') <span class="ferror">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Productos y Categorías vinculados --}}
                <div class="fgroup" style="margin-bottom:1.3rem;">
                    <label class="flabel">Productos específicos (opcional)</label>
                    <select name="product_scope"
                            id="product_scope"
                            class="fselect"
                            onchange="toggleProductSelect()">
                        <option value="none" selected>No aplicar a ningún producto</option>
                        <option value="all">Todos los productos</option>
                        <option value="specific">Seleccionar productos específicos</option>
                    </select>
                    <div id="specific-products" style="display:none;margin-top:0.8rem;">
                        <select name="product_ids[]"
                                id="product_ids"
                                class="fselect"
                                multiple
                                size="5"
                                style="height:auto;">
                            <option value="" disabled>Seleccioná productos (Ctrl+click para varios)</option>
                            @php $selectedProducts = $isEdit ? $promo->products()->pluck('products.id')->toArray() : []; @endphp
                            @foreach(\App\Models\Product::where('is_active', true)->orderBy('name')->get() as $prod)
                            <option value="{{ $prod->id }}" {{ in_array($prod->id, old('product_ids', $selectedProducts)) ? 'selected' : '' }}>{{ $prod->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="fgroup" style="margin-bottom:1.3rem;">
                    <label class="flabel">Categoría específica (opcional)</label>
                    <select name="categoria_id"
                            id="categoria_id"
                            class="fselect">
                        <option value="none" selected>No aplicar a ninguna categoría</option>
                        <option value="">Todas las categorías</option>
                        @php $selectedCat = $isEdit && $promo->categories()->count() > 0 ? $promo->categories()->first()->id : ''; @endphp
                        @foreach(\App\Models\Category::orderBy('name')->get() as $cat)
                        <option value="{{ $cat->id }}" {{ old('categoria_id', $selectedCat) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <script>
                function toggleProductSelect() {
                    const scope = document.getElementById('product_scope').value;
                    document.getElementById('specific-products').style.display = (scope === 'specific') ? 'block' : 'none';
                }
                </script>
            </div>
        </div>

        {{-- ── PANEL LATERAL ───────────────────────────── --}}
        <div style="display:flex;flex-direction:column;gap:1.2rem;position:sticky;top:76px;">

            {{-- Acciones --}}
            <div class="acard">
                <div class="acard-header">
                    <span class="acard-title">Publicar</span>
                </div>
                <div class="acard-body" style="display:flex;flex-direction:column;gap:0.7rem;">
                    <button type="submit" class="abtn abtn-lime" style="justify-content:center;width:100%;padding:11px;">
                        {{ $isEdit ? '💾 Guardar cambios' : '+ Crear promoción' }}
                    </button>
                    <a href="{{ route('admin.promociones.index') }}" class="abtn abtn-outline" style="justify-content:center;">
                        Cancelar
                    </a>
                </div>
            </div>

            {{-- Vista previa --}}
            <div>
                <p style="font-family:var(--font-mono);font-size:0.62rem;text-transform:uppercase;letter-spacing:0.15em;color:var(--text-3);margin-bottom:0.6rem;">
                    Vista previa
                </p>
                <div class="promo-preview">
                    <span class="promo-preview__label">Preview</span>
                    <span class="promo-preview__tag">Promo</span>
                    <div class="promo-preview__title" id="preview-titulo">
                        {{ $promo->titulo ?? 'Título de la promoción' }}
                    </div>
                    <div class="promo-preview__desc" id="preview-desc">
                        {{ Str::limit($promo->descripcion ?? 'La descripción aparecerá aquí...', 80) }}
                    </div>
                    <span style="display:inline-block;padding:6px 14px;background:var(--lime);color:var(--bg);border-radius:var(--radius);font-size:0.75rem;font-weight:700;font-family:var(--font-body);letter-spacing:0.05em;">
                        Ver promoción →
                    </span>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- Botones de acción fuera del formulario principal (para evitar anidamiento de forms) --}}
@if($isEdit)
<div style="margin-top:1rem;">
    <div style="border-top:1px solid var(--border-solid);padding-top:1rem;margin-bottom:1rem;">
        {{-- Toggle rápido --}}
        <form action="{{ route('admin.promociones.toggle', $promo) }}"
              method="POST"
              style="margin-bottom:0.5rem;">
            @csrf @method('PATCH')
            <button type="submit"
                    class="abtn abtn-outline"
                    style="width:100%;justify-content:center;{{ $promo->activa ? 'border-color:rgba(239,68,68,0.3);color:#fca5a5;' : 'border-color:rgba(34,197,94,0.3);color:#86efac;' }}">
                {{ $promo->activa ? '⏸ Desactivar' : '▶ Activar' }}
            </button>
        </form>

        {{-- Eliminar --}}
        <form action="{{ route('admin.promociones.destroy', $promo) }}"
              method="POST"
              onsubmit="return confirm('¿Eliminar esta promoción permanentemente?')">
            @csrf @method('DELETE')
            <button type="submit" class="abtn abtn-danger" style="width:100%;justify-content:center;">
                Eliminar
            </button>
        </form>
    </div>
</div>
@endif

@push('scripts')
<script>
/* ── Live preview ─────────────────────────────────────── */
function updatePreview() {
    const titulo = document.getElementById('titulo').value || 'Título de la promoción';
    const desc   = document.getElementById('descripcion').value || 'La descripción aparecerá aquí...';

    document.getElementById('preview-titulo').textContent = titulo;
    document.getElementById('preview-desc').textContent   = desc.length > 80 ? desc.slice(0, 80) + '...' : desc;
}

/* ── Checkbox color inicial ───────────────────────────── */
const activaCheck = document.getElementById('activa');
const activaLabel = document.getElementById('activa-label');
if (activaCheck && activaCheck.checked) {
    activaLabel.style.borderColor = 'var(--lime)';
}
</script>
@endpush