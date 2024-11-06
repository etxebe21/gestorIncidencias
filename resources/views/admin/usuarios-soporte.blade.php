<x-app-layout>
    <div x-data="notification()" x-init="init()" class="overflow-x-auto">
       
        <div x-show="visible" x-transition class="fixed top-20 right-0 mt-4 mr-4">
            <div class="bg-green-500 text-white p-4 rounded shadow">
                <span x-text="message"></span>
            </div>
        </div>
        <x-slot name="header">
            <h3 class="text-xl font-semibold mb-4 flex justify-between items-center">
                {{ __('USUARIOS DE SOPORTE') }}
                <a href="{{ route('usuarios.create') }}" class="flex items-center bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600 transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Crear Usuario
                </a>
            </h3>
        </x-slot>
        
        <div class="container mx-auto px-4 mt-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach ($users as $user)
                    <div class="relative bg-white rounded-lg shadow-md p-6 w-full h-64 flex flex-col justify-between items-center text-center max-w-xs mx-auto">
                        <!-- Botón de borrar -->
                        <form action="{{ route('usuarios.destroy', $user->id) }}" method="POST" class="absolute top-2 right-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-2 py-1 text-sm text-center text-white bg-red-500 rounded-lg hover:bg-red-600 transition duration-300" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white-600 hover:text-white-800" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </form>
        
                        <h5 class="font-medium text-xl mb-2">{{ $user->name }}</h5>
                        <p class="text-gray-600 mb-4">Correo: {{ $user->email }}</p>
                        
                        <a href="{{ route('usuarios.incidencias', $user->id) }}" 
                        class="flex items-center justify-center w-full bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition duration-300">
                            Ver incidencias
                        </a>
                    </div>
                @endforeach
            </div>
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

