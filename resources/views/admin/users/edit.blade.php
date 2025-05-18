@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white shadow rounded-lg">
    <h2 class="text-xl font-bold mb-4">Editar Usuario</h2>

    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700">Nombre</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Rol</label>
            <select name="role" class="w-full border px-3 py-2 rounded" required>
                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Usuario</option>
                <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Estudiante</option>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrador</option>
                <option value="teacher" {{ $user->role === 'teacher' ? 'selected' : '' }}>Profesor</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Actualizar</button>
        <a href="{{ route('admin.users.index') }}" class="ml-2 text-gray-600 hover:underline">Cancelar</a>
    </form>
</div>
@endsection