<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nosso propósito') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-8">

                {{-- Seção principal --}}
                <h1 class="text-3xl font-bold mb-6">Nosso propósito</h1>

                <p class="text-gray-700 leading-relaxed mb-6">
                    A STAB é uma iniciativa que organiza eventos de corrida com o objetivo de arrecadar fundos
                    para apoiar causas sociais e ajudar pessoas em situação de vulnerabilidade. Através de
                    corridas, promovemos a saúde e o bem-estar dos participantes, enquanto destinamos toda a
                    arrecadação para instituições de caridade e ações que atendem aos mais necessitados.
                    Nosso propósito é unir esporte e solidariedade, criando um impacto positivo na sociedade
                    incentivando a participação ativa de todos para um mundo mais justo e colaborativo.
                </p>

                <div class="flex flex-col md:flex-row gap-8 mb-8">
                    {{-- Card Quero participar --}}
                    <div class="w-full md:w-1/3 bg-gray-100 p-6 rounded-lg shadow">
                        <h2 class="text-xl font-semibold mb-4">Quero participar</h2>
                        <p class="text-sm text-gray-600 mb-4">
                            Insira seu e-mail para mais informações.
                        </p>
                        <form class="flex flex-col gap-4">
                            <input type="email" placeholder="E-mail"
                                   class="border rounded px-3 py-2 w-full focus:ring focus:ring-indigo-300"/>
                            <button type="submit"
                                    class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800">
                                Participar
                            </button>
                        </form>
                    </div>

                    {{-- Imagem + Texto --}}
                    <div class="w-full md:w-2/3">
                        <img src="{{asset('assets/stab.jpg')}}" alt="Grupo de corrida"
                             class="rounded-lg mb-4 shadow"/>
                        <p class="text-gray-700 leading-relaxed">
                            Em cidades como Santo André, o projeto tem ganhado força, oferecendo aos moradores a
                            oportunidade de se engajarem em ações solidárias enquanto cuidam da sua saúde.
                            As corridas são realizadas em diferentes locais da cidade, como praças e parques,
                            garantindo acessibilidade e participação de todas as idades. A cada edição, o evento
                            atrai mais participantes e voluntários, criando um ambiente de união e solidariedade.
                            Além de promover a prática esportiva, buscamos conscientizar a população sobre a
                            importância de ajudar o próximo, gerando um impacto positivo tanto na cidade quanto
                            nas comunidades assistidas pelas doações.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
