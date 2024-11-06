<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('ADMINISTRADOR') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Bienvenido, {{ Auth::user()->name }}</h3>
                    <p>{{ __("En este panel puedes gestionar todas las incidencias. Puedes crear, editar y eliminar incidencias, así como asignarlas al soporte.") }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" dark:bg-gray-500 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="mt-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Tarjeta para ver usuarios de soporte -->
                    <div class="bg-white rounded-lg shadow-md transition-transform transform hover:scale-105 hover:shadow-lg p-4">
                        <h5 class="font-medium text-xl mb-2">Ver usuarios de soporte</h5>
                        <p class="text-gray-600">Consulta la lista de usuarios de soporte disponibles.</p>
                        <a href="{{ route('usuarios.soporte') }}" class="flex items-center justify-center w-full bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition duration-300 mt-6">Ver soporte</a>
                    </div>
                    <!-- Tarjeta para ver todas las incidencias -->
                    <div class="bg-white rounded-lg shadow-md transition-transform transform hover:scale-105 hover:shadow-lg p-4">
                        <h5 class="font-medium text-xl mb-2">Ver todas las incidencias</h5>
                        <p class="text-gray-600">Accede a la lista completa de incidencias registradas.</p>
                        <a href="{{ route('incidencias.index') }}" class="flex items-center justify-center w-full bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition duration-300 mt-6">Ir a incidencias</a>
                    </div>      
                    <!-- Tarjeta para crear nueva incidencia -->
                    <div class="bg-white rounded-lg shadow-md transition-transform transform hover:scale-105 hover:shadow-lg p-4">
                        <h5 class="font-medium text-xl mb-2">Crear nueva incidencia</h5>
                        <p class="text-gray-600">Registra una nueva incidencia para su seguimiento.</p>
                        <a href="{{ route('incidencias.create') }}" class="flex items-center justify-center w-full bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition duration-300 mt-6">Crear incidencia</a>
                    </div> 
                </div>
            </div>          
        </div>
    </div>
       
</x-app-layout>
