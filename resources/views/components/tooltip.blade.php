@props(['id', 'content'])
@php
    $id = $id ?? md5(rand(0,100) * 10000);
@endphp
{{$slot}}
<div id="{{$id}}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
    {{$content}}
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>
