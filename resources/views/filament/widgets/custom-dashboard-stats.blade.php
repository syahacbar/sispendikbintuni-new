<x-filament::widget>
    <x-filament::card>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach ($cards as $card)
                <div class="bg-white p-4 shadow rounded-xl">
                    <div class="text-sm text-gray-500">{{ $card['title'] }}</div>
                    <div class="text-2xl font-bold text-primary-600">{{ $card['value'] }}</div>
                    <div class="text-xs text-gray-400">{{ $card['description'] ?? '' }}</div>
                </div>
            @endforeach
        </div>
    </x-filament::card>
</x-filament::widget>
