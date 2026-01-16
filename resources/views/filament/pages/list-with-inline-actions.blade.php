<x-filament-panels::page>
    <style>
        .custom-header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
            margin-bottom: 1rem;
        }

        .custom-header-actions .search-container {
            flex: 1;
        }

        .custom-header-actions .actions-container {
            flex-shrink: 0;
        }
    </style>

    <div class="custom-header-actions">
        <div class="search-container">
            {{ $this->table }}
        </div>
    </div>
</x-filament-panels::page>