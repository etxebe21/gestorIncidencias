<x-app-layout>
    <div x-data="notification()" x-init="init()" class="overflow-x-auto">
       
        <div x-show="visible" x-transition class="fixed top-20 right-0 mt-4 mr-4">
            <div class="bg-green-500 text-white p-4 rounded shadow">
                <span x-text="message"></span>
            </div>
        </div>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Incidencias de: ' . $user->name) }}
            </h2>
        </x-slot>

        <div class="container mx-auto px-4 mt-10">
            <h3 class="text-xl font-semibold mb-4 flex justify-between items-center">
                Incidencias asignadas a {{ $user->name }}
                <a href="{{ route('usuarios.incidencias.create', $user) }}" class="flex items-center bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600 transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Crear incidencia
                </a>
            </h3>
            
            
            @if ($incidencias->isEmpty())
                <p>No hay incidencias asignadas a este usuario.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach ($incidencias as $incidencia)
                        <div class="w-full max-w-lg bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 p-4">
                            <div class="flex flex-col items-center pb-4">
                                <h5 class="mb-2 text-xl font-medium text-gray-900 dark:text-white">{{ $incidencia->titulo }}</h5>
                                <span class="text-sm text-gray-500 dark:text-gray-400 mt-2">{{ $incidencia->descripcion }}</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400 mt-4">Estado: {{ $incidencia->estado }}</span>
                            </div>
                            <div class="flex justify-center mt-4 space-x-4">
                                <button onclick="window.location='{{ route('usuarios.incidencias.edit', $incidencia->id) }}'"class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-orange-500 rounded-lg hover:bg-orange-600 transition duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232a1 1 0 00-1.414 0l-9 9a1 1 0 00-.268.5L4 16a1 1 0 001 1h1.268a1 1 0 00.5-.268l9-9a1 1 0 000-1.414l-1.536-1.536z" />
                                    </svg>
                                    Editar
                                </button>
                                <form action="{{ route('usuarios.incidencias.destroy', $incidencia) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-red-500 rounded-lg hover:bg-red-600 transition duration-300" onclick="return confirm('¿Estás seguro de que deseas eliminar esta incidencia?');">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M9 6v14a2 2 0 002 2h2a2 2 0 002-2V6M4 6l2-2h12l2 2H4z" />
                                        </svg>
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            <a href="{{ route('usuarios.soporte') }}" class="mt-4 inline-block bg-gray-500 text-white py-2 px-4 rounded mb-6">Regresar</a>
        </div>
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
