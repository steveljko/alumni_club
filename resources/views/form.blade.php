<form id="{{ $name }}" data-method="{{ $method }}" data-action="{{ $route }}">
    <div id="errors"></div>

    @foreach ($fields as $field)
        <div class="mb-4">
            @if (!empty($field['options']['label']))
                <label class="uppercase text-sm font-semibold" for="{{ $field['name'] }}">{{ $field['options']['label'] }}</label>
            @endif

            @switch($field['type'])
                @case('text')
                    <input
                        name="{{ $field['name'] }}"
                        type="{{ $field['options']['inputType'] ?? 'text' }}"
                        placeholder="{{ $field['options']['placeholder'] ?? '' }}"
                        value="{{ old($field['name']) }}"
                        class="block"
                    />
                    @break

                @case('select')
                    <select name="{{ $field['name'] }}" class="block">
                        @if (!empty($field['options']['label']))
                            <option selected disabled>{{ $field['options']['label'] }}</option>
                        @endif
                        @foreach ($field['options']['options'] as $option)
                            <option value="{{ $option->getValue() }}">{{ $option->getName() }}</option>
                        @endforeach
                    </select>
                    @break

                @case('hidden')
                    <input type="hidden" name="{{ $field['name'] }}" value="{{ old($field['name']) }}">
                    @break
            @endswitch

            @if ($field['name'] !== 'id')
                <div id="error-{{ $field['name'] }}" class="block mt-2 text-sm text-red-500"></div>
            @endif
        </div>
    @endforeach

    <button class="w-full px-2 py-1 bg-blue-700 rounded">{{ $buttonText ?? 'Submit' }}</button>
</form>
