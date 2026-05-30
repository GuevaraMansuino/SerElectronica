@props([
    'columns' => [],
    'data' => [],
    'emptyMessage' => 'No hay datos disponibles'
])

{{--
    Uso:
    @include('components.data-table', [
        'columns' => [
            ['label' => 'Nombre', 'key' => 'name'],
            ['label' => 'Email', 'key' => 'email'],
            ['label' => 'Acciones', 'key' => 'actions', ' sortable' => false]
        ],
        'data' => $users,
        'emptyMessage' => 'No hay usuarios'
    ])
--}}

<div class="data-table-wrapper">
    <table class="data-table">
        <thead>
            <tr>
                @foreach($columns as $column)
                    <th class="{{ isset($column['class']) ? $column['class'] : '' }}">
                        {{ $column['label'] }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($data as $item)
                <tr>
                    @foreach($columns as $column)
                        <td class="{{ isset($column['class']) ? $column['class'] : '' }}">
                            @if($column['key'] === 'actions')
                                {{ $slot }}
                            @else
                                {{ data_get($item, $column['key']) }}
                            @endif
                        </td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($columns) }}" class="data-table__empty">
                        {{ $emptyMessage }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
