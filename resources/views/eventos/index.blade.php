<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css' rel='stylesheet'/>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>

@php
    $userId = auth()->id();
@endphp

<x-app-layout>
    {{-- Alertas --}}
    @if ($errors->any())
        <div id="alert-message"
             class="flex items-center justify-between bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-md mt-3"
             role="alert">
            <span class="font-medium">{{ $errors->first() }}</span>
            <button onclick="this.parentElement.remove()" class="ml-4 text-red-500 hover:text-red-700">✕</button>
        </div>
    @endif

    @if (session('message'))
        <div id="alert-message"
             class="flex items-center justify-between bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-md mt-3"
             role="alert">
            <span class="font-medium">{{ session('message') }}</span>
            <button onclick="this.parentElement.remove()" class="ml-4 text-green-500 hover:text-green-700">✕</button>
        </div>
    @endif

    {{-- Calendário --}}
    <div class="bg-white shadow-md rounded-xl p-4 mt-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">📅 Eventos</h2>
        <div id="calendar" class="rounded-lg overflow-hidden"></div>
    </div>

    {{-- Modal Criar Evento --}}
    <x-modal name="create-event" focusable id="create-event">
        <form method="post" action="{{ route('eventos.criar') }}" class="p-6 space-y-4">
            @csrf
            <h2 class="text-lg font-semibold text-gray-800 mb-2">➕ Criar Novo Evento</h2>

            <div>
                <x-input-label :value="__('Nome')" />
                <x-text-input
                    id="nome"
                    name="nome"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="nome"
                />
            </div>

            <div>
                <x-input-label :value="__('Data')" />
                <x-text-input
                    id="data"
                    name="data"
                    type="datetime-local"
                    class="mt-1 block w-full"
                    autocomplete="data"
                />
            </div>

            <div>
                <x-input-label :value="__('Duração (h.m)')" />
                <x-text-input
                    id="duracao"
                    name="duracao"
                    type="number"
                    step="0.01"
                    class="mt-1 block w-full"
                    autocomplete="duracao"
                />
            </div>

            <div class="flex justify-end gap-4">
                <x-secondary-button type="button" x-on:click="$dispatch('close')">Cancelar</x-secondary-button>
                <x-primary-button>{{ __('Salvar') }}</x-primary-button>
            </div>
        </form>
    </x-modal>

    {{-- Modal Registrar Evento --}}
    <x-modal name="registar-modal" focusable id="registar-modal">
        <form method="post" action="{{ route('eventos.registrar') }}" class="p-6 space-y-4 text-center">
            @csrf
            <x-text-input id="evento_id" name="evento_id" type="hidden" />

            <h2 class="text-lg font-semibold text-gray-800">
                {{ __('Deseja se registrar neste evento?') }}
            </h2>

            <p class="mt-2 text-sm text-gray-600" id="evento-descricao"></p>

            <div class="flex justify-center mt-5 gap-4">
                <x-secondary-button type="button" x-on:click="$dispatch('close')">Cancelar</x-secondary-button>
                <x-primary-button>{{ __('Sim, registrar!') }}</x-primary-button>
            </div>
        </form>
    </x-modal>

    {{-- Script do calendário e alertas --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'pt-br',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: @json($eventos),
                dateClick: function (info) {
                    window.dispatchEvent(new CustomEvent('open-modal', {detail: 'create-event'}));
                    document.getElementById('data').value = info.dateStr + 'T00:00';
                },
                eventClick: function (info) {
                    info.jsEvent.preventDefault();
                    window.dispatchEvent(new CustomEvent('open-modal', {detail: 'registar-modal'}));
                    document.getElementById('evento_id').value = info.event.id;
                    document.getElementById('evento-descricao').innerHTML =
                        'Você está prestes a se inscrever no evento <strong>' + info.event.title +
                        '</strong> que ocorrerá em: <strong>' + info.event.start.toLocaleString() + '</strong>.' +
                        'Com a duração de <strong>' + (info.event.extendedProps.duracao || 'N/A') + ' horas</strong>.';
                }
            });
            calendar.render();
        });

        // Esconde alerta automaticamente
        setTimeout(() => {
            const alert = document.getElementById('alert-message');
            if (alert) {
                alert.style.transition = "opacity 0.5s ease";
                alert.style.opacity = 0;
                setTimeout(() => alert.remove(), 500);
            }
        }, 4000);
    </script>
</x-app-layout>
