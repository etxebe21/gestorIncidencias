<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Incidencia') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6">
                    <form action="{{ route('incidencias.update', $incidencia) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="titulo" class="block font-medium text-gray-700">Título</label>
                            <input type="text" name="titulo" id="titulo" value="{{ $incidencia->titulo }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        </div>

                        <div class="mb-4">
                            <label for="descripcion" class="block font-medium text-gray-700">Descripción</label>
                            <textarea name="descripcion" id="descripcion" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">{{ $incidencia->descripcion }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="assigned_to" class="block font-medium text-gray-700">Asignado a</label>
                            <select name="assigned_to" id="assigned_to" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                <option value="">Selecciona una persona</option>
                                @foreach ($users as $user) <!-- Asegúrate de pasar la lista de usuarios desde el controlador -->
                                    <option value="{{ $user->id }}" {{ $user->id == $incidencia->assigned_to ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        

                        <div class="mb-4">
                            <label for="estado" class="block font-medium text-gray-700">Estado</label>
                            <select name="estado" id="estado" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                <option value="To Do" {{ $incidencia->estado == 'To Do' ? 'selected' : '' }}>Pendiente</option>
                                <option value="Doing" {{ $incidencia->estado == 'Doing' ? 'selected' : '' }}>En proceso</option>
                                <option value="Done" {{ $incidencia->estado == 'Done' ? 'selected' : '' }}>Completada</option>
                            </select>
                        </div>
                        

                        <div class="mt-4">
                            <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition duration-300">
                                Actualizar Incidencia
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
