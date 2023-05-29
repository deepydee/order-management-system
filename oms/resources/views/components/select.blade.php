@props(['options'])

<select {{ $attributes->merge(['class' => 'w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mt-1']) }}>
    <option value="">{{ __('Choose ' . $attributes['name']) }}</option>
    @foreach($options as $key => $value)
        <option value="{{ $key }}">{{ $value }}</option>
    @endforeach
</select>
