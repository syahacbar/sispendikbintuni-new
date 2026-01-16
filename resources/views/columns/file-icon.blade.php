@php
    // DEBUG: Let's see what variables are available
    // $debugInfo = [
    //     'getState' => isset($getState) ? 'exists' : 'not exists',
    //     'state' => isset($state) ? gettype($state) : 'not exists',
    //     'record' => isset($record) ? 'exists' : 'not exists',
    //     'all_vars' => array_keys(get_defined_vars())
    // ];

    // Get the file path from multiple possible sources
    $filePath = null;

    // Method 1: Try getState() if available (ViewColumn passes this)
    if (isset($getState) && is_callable($getState)) {
        $filePath = $getState();
    }

    // Method 2: Try $state directly
    if (empty($filePath) && isset($state) && is_string($state)) {
        $filePath = $state;
    }

    // Method 3: Try from record object
    if (empty($filePath) && isset($record) && isset($record->dok_lampiran)) {
        $filePath = $record->dok_lampiran;
    }

    // Clean up if it's still a Closure or object
    if ($filePath instanceof \Closure || is_object($filePath)) {
        $filePath = null;
    }

    $extension = $filePath ? pathinfo($filePath, PATHINFO_EXTENSION) : null;
    $url = $filePath ? (str_starts_with($filePath, 'http') ? $filePath : asset('storage/' . $filePath)) : '#';
@endphp

<div class="px-4 py-3">
    @if($filePath)
        <a href="{{ $url }}" target="_blank" title="{{ $filePath }}"
            class="inline-flex items-center justify-center transition hover:scale-110">
            @if(in_array(strtolower($extension), ['pdf']))
                <x-heroicon-o-document-text class="w-6 h-6 text-red-500" />
            @elseif(in_array(strtolower($extension), ['doc', 'docx']))
                <x-heroicon-o-document-text class="w-6 h-6 text-blue-500" />
            @elseif(in_array(strtolower($extension), ['xls', 'xlsx', 'csv']))
                <x-heroicon-o-table-cells class="w-6 h-6 text-green-500" />
            @elseif(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                <x-heroicon-o-photo class="w-6 h-6 text-amber-500" />
            @else
                <x-heroicon-o-document class="w-6 h-6 text-gray-500" />
            @endif
        </a>
    @else
        <div
            class="inline-flex items-center rounded-md bg-gray-50 text-gray-600 px-2 py-1 text-xs font-medium ring-1 ring-inset ring-gray-500/10">
            Tidak ada file
        </div>
    @endif
</div>