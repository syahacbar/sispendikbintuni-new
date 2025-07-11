<x-filament-panels::page>

    <div class="flex justify-end">
        {{ $this->createAction() }}
    </div>

    <x-filament::section>
        <div wire:ignore id="kalender">
    </x-filament::section>

    {{ $this->table }}


    @assets
        <script src="{{ asset('js/fullcalendar/fullcalendar.js') }}" data-navigate-once></script>
    @endassets


    @script
        <script>
            const calendarFunction = () => {

                let calendarEl = document.getElementById('kalender');
                let calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,listWeek'
                    },
                    events: [{
                        title: 'The Title',
                        start: '2025-07-15',
                        end: '2025-07-17'
                    }]
                });
                calendar.render();
            }


            document.addEventListener('livewire:navigated', () => {
                calendarFunction();
            })
        </script>
    @endscript


</x-filament-panels::page>
