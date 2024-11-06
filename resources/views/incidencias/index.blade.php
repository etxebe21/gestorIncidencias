<x-app-layout>
    <x-slot name="header">
        <h3 class="text-xl font-semibold mb-4 flex justify-between items-center">
            {{ __('INCIDENCIAS') }}
            <a href="{{ route('incidencias.create') }}" class="flex items-center bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Crear Incidencia
            </a>
        </h3>
    </x-slot>
    <div x-data="notification()" x-init="init()" class="overflow-x-auto">
        <!-- Componente de Notificación -->
        <div x-show="visible" x-transition class="fixed top-0 right-0 mt-4 mr-4">
            <div class="bg-green-500 text-white p-4 rounded shadow">
                <span x-text="message"></span>
            </div>
        </div>

        <table class="min-w-full mt-4 border-collapse border border-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2 border border-gray-300">Incidencia</th>
                    <th class="px-4 py-2 border border-gray-300">Descripción</th>
                    <th class="px-4 py-2 border border-gray-300">Estado</th>
                    <th class="px-4 py-2 border border-gray-300">Asignado a</th>
                    <th class="px-4 py-2 border border-gray-300">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($incidencias as $incidencia)
                    <tr>
                        <td class="border px-4 py-2">{{ $incidencia->titulo }}</td>
                        <td class="border px-4 py-2">{{ $incidencia->descripcion }}</td>
                        <td class="border px-4 py-2">{{ $incidencia->estado }}</td>
                        <td class="border px-4 py-2">
                            {{ $incidencia->asignadoA ? $incidencia->asignadoA->name : 'No asignado' }}
                        </td>
                        <td class="border px-4 py-2 flex space-x-2 ">
                            <a href="{{ route('incidencias.edit', $incidencia) }}" class="flex items-center justify-center w-full bg-orange-400 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232a1 1 0 00-1.414 0l-9 9a1 1 0 00-.268.5L4 16a1 1 0 001 1h1.268a1 1 0 00.5-.268l9-9a1 1 0 000-1.414l-1.536-1.536z" />
                                </svg>
                                Editar
                            </a>
                            <form action="{{ route('incidencias.destroy', $incidencia) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE') 
                                <button type="submit" class="flex items-center justify-center w-full bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-700 transition duration-300" onclick="return confirm('¿Estás seguro de que deseas eliminar esta incidencia?');">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M9 6v14a2 2 0 002 2h2a2 2 0 002-2V6M4 6l2-2h12l2 2H4z" />
                                    </svg>
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function notification() {
            return {
                message: "{{ session('success') }}",
                visible: false,
                init() {
                    if (this.message) {
                        this.visible = true;
                        setTimeout(() => {
                            this.visible = false;
                        }, 3000); 
                    }
                }
            }
        }
    </script>

</x-app-layout>
