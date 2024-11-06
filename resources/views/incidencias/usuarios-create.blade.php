<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Incidencia') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6">
                    <form action="{{ route('usuarios.incidencias.store', $user) }}" method="POST">                        @csrf
                       
                        <div>
                            <label for="titulo" class="block font-medium text-gray-700">Título</label>
                            <input type="text" name="titulo" id="titulo" required class="mt-1 block w-full border-gray-300 rounded">
                        </div>

                        <div class="mt-4">
                            <label for="descripcion" class="block font-medium text-gray-700">Descripción</label>
                            <textarea name="descripcion" id="descripcion" required class="mt-1 block w-full border-gray-300 rounded"></textarea>
                        </div>

                        <div class="mt-4">
                            <label for="estado" class="block font-medium text-gray-700">Estado</label>
                            <select name="estado" id="estado" class="mt-1 block w-full border-gray-300 rounded">
                                <option value="To Do">To Do</option>
                                <option value="Doing">Doing</option>
                                <option value="Done">Done</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            
                            <input type="hidden" name="assigned_to" value="{{ $user }}">

                        </div>

                        <div class="mt-4">
                            <button type="submit" class="flex items-center justify-center bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition duration-300 mt-6">Crear Incidencia</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
