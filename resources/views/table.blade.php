<div>
    <table id="{{ $name }}" class="w-full min-w-full table-auto select-none">
        <thead class="bg-gray-100 text-xs text-gray-700 border-b border-gray-200 uppercase">
            <tr>
                @foreach ($columns as $column)
                    <th scope="col" class="{{ $column['header'] == '#' ? 'py-3 text-center' : 'px-6 py-3 text-left' }}">
                        {{ $column['header'] }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($data->items() as $key => $model)
                <tr class="hover:bg-gray-100 hover:cursor-pointer" :data-index="{{ $key }}">
                    @foreach ($columns as $column)
                        @php
                            $field = $column["field"];
                            $relation = str_contains($field, '.') ? explode('.', $field, 2) : null;
                        @endphp

                        <td scope="row" class="{{ $column['type'] == 'index' ? 'w-[2.5rem] py-4 font-medium text-gray-900 whitespace-nowrap text-center' : 'px-6 py-4 text-left' }}">
                            @if ($column['type'] == 'field')
                                {{ $relation ? $model->{$relation[0]}->{$relation[1]} : $model->{$field} }}
                            @elseif ($column['type'] == 'index')
                                <!-- TODO: Display row index right -->
                                {{ $key + 1 }}
                            @else
                                <a data-user="{{ $model }}" class="edit-button inline-flex items-center font-medium text-sm text-yellow-500">
                                    @svg('far-edit', 'w-4 h-4 text-yellow-500 mr-1') Izmeni
                                </a>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    @if ($pagination)
        <x-pagination :model="$data" />
    @endif
</div>
