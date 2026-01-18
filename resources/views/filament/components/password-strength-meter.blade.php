@if($strength && $strength['feedback'] && !str_contains($strength['feedback'], 'memenuhi semua kriteria'))
    <div class="mb-4 px-1">
        <div class="text-xs text-gray-600 dark:text-gray-400">
            {{ $strength['feedback'] }}
        </div>
    </div>
@endif