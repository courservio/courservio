@props([
    'active' => '',
    'href' => '#'
])

<a href="{{ $href }}" class="{{ $active ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
    {{ $slot }}
</a>
