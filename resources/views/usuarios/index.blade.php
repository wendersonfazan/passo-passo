<x-app-layout>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.css"/>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js" defer></script>

    {{-- Alertas --}}
    @if ($errors->any())
        <div id="alert-message"
             class="flex items-center justify-between bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg shadow-md mt-4"
             role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                          d="M18 10A8 8 0 11 2 10a8 8 0 0116 0zm-7 4a1 1 0 10-2 0 1 1 0 002 0zm-.25-8.75a.75.75 0 00-1.5 0v5a.75.75 0 001.5 0v-5z"
                          clip-rule="evenodd"/>
                </svg>
                <span class="font-medium">{{ $errors->first() }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-4 text-red-400 hover:text-red-600">✕</button>
        </div>
    @endif

    @if (session('message'))
        <div id="alert-message"
             class="flex items-center justify-between bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded-lg shadow-md mt-4"
             role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 10-1.414 1.414L9 13.414l4.707-4.707z"
                          clip-rule="evenodd"/>
                </svg>
                <span class="font-medium">{{ session('message') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-4 text-green-400 hover:text-green-600">✕</button>
        </div>
    @endif

    <div class="bg-white shadow-lg rounded-2xl p-6 mt-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Usuários</h2>
        </div>

        <div class="overflow-x-auto">
            <table id="usersTable" class="display w-full border-collapse">
                <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left">Nome</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-center">Admin</th>
                    <th class="px-4 py-2 text-center">Ações</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @foreach ($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 font-medium text-gray-800">{{ $user->name }}</td>
                        <td class="px-4 py-2 text-gray-600">{{ $user->email }}</td>
                        <td class="px-4 py-2 text-center">
                            <span
                                class="px-2 py-1 text-xs font-semibold rounded-full {{ $user->is_admin ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ $user->is_admin ? 'Sim' : 'Não' }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-center space-x-2">
                            @if (auth()->id() !== $user->id)
                                <button
                                    type="button"
                                    class="inline-flex items-center px-3 py-1 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-sm font-medium transition"
                                    onclick="if(confirm('Tem certeza que deseja deletar este usuário?')) { document.getElementById('delete-user-{{ $user->id }}').submit(); }"
                                >
                                    Deletar
                                </button>
                                <form id="delete-user-{{ $user->id }}" method="POST"
                                      action="{{ route('usuarios.deletar', $user->id) }}" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endif

                            <form method="POST" action="{{ route('usuarios.setar-admin', $user->id) }}" class="inline">
                                @csrf
                                <button type="submit"
                                        class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg text-sm font-medium transition">
                                    {{ $user->is_admin ? 'Remover Admin' : 'Tornar Admin' }}
                                </button>
                            </form>


                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            new DataTable('#usersTable', {
                language: {
                    url: '//cdn.datatables.net/plug-ins/2.3.4/i18n/pt-BR.json'
                },
                pageLength: 10,
                responsive: true
            });
        });
    </script>
</x-app-layout>
