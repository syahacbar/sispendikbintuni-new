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
                    editable: true,
                    selectable: true,
                    eventResizableFromStart: true,
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,listWeek'
                    },
                    height: 600,

                    eventResize: function(info) {
                        $wire.mountAction('droppedEvent', {
                            id: info.event.id,
                            startDate: info.event.startStr,
                            endDate: info.event.endStr
                        });
                    },

                    eventClick: function(info) {
                        $wire.mountAction('viewAction', {
                            id: info.event.id
                        });
                    },

                    select: function(info) {
                        $wire.set('startDate', info.startStr);
                        $wire.set('endDate', info.endStr);
                        $wire.mountAction('createAction');
                    },

                    eventDrop: function(info) {
                        $wire.mountAction('droppedEvent', {
                            id: info.event.id,
                            startDate: info.event.startStr,
                            endDate: info.event.endStr
                        });
                    },

                    events: JSON.parse($wire.events)
                });
                calendar.render();
            }


            document.addEventListener('livewire:navigated', () => {
                calendarFunction();
            });


            $wire.on('refresh-calendar', () => {
                calendarFunction();
            });
        </script>
    @endscript


</x-filament-panels::page>
