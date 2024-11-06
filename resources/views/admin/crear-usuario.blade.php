<x-app-layout>

    <div class="container mx-auto p-6">
        <h3 class="text-xl font-semibold mb-4 flex justify-between items-center">
            {{ __('CREAR USUARIO') }}
        </h3>

        <form action="{{ route('usuarios.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Nombre:</label>
                <input type="text" id="name" name="name" class="border rounded w-full py-2 px-3" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700">Correo Electrónico:</label>
                <input type="email" id="email" name="email" class="border rounded w-full py-2 px-3" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700">Contraseña:</label>
                <input type="password" id="password" name="password" class="border rounded w-full py-2 px-3" required>
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700">Confirmar Contraseña:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="border rounded w-full py-2 px-3" required>
            </div>

            <div class="mb-4">
                <label for="role" class="block text-gray-700">Rol:</label>
                <select id="role" name="role" class="border rounded w-full py-2 px-3">
                    <option value="admin">Admin</option>
                    <option value="soporte">Soporte</option>
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700">Crear Usuario</button>
            </div>
        </form>
    </div>

</x-app-layout>