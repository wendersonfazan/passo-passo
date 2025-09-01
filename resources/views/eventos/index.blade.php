<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>

<x-app-layout>
    <div id="calendar"></div>

    @if (session('error') === 'Evento já existe')
        <p class="mt-2 font-medium text-sm text-green-600">
            {{ __('Evento já existe') }}
        </p>
    @endif

    <x-modal name="create-event" focusable id="create-event">
        <form method="post" action="{{ route('eventos.criar') }}" class="p-6">
            @csrf
            <div>
                <x-input-label :value="__('Nome')" />
                <x-text-input id="nome" name="nome" type="text" class="mt-1 block w-full" autocomplete="nome" />
            </div>

            <div>
               <x-input-label :value="__('data')" />
               <x-text-input id="data" name="data" type="datetime-local" class="mt-1 block w-full" autocomplete="data" />
           </div>

            <div>
                <x-input-label :value="__('duracao')" />
                <x-text-input id="duracao" name="duracao" type="number" class="mt-1 block w-full" autocomplete="duracao" />
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Salvar') }}</x-primary-button>
            </div>
        </form>
    </x-modal>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'pt-br',
                events: @json($eventos),
                dateClick: function(info) {
                    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'create-event' }));
                    document.getElementById('data').value = info.dateStr + 'T00:00';
                }
            });
            calendar.render();
        });
    </script>

</x-app-layout>
