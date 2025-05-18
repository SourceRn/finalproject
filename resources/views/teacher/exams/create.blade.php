@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Crear Examen</h1>

    <form action="{{ route('teacher.exams.store') }}" method="POST" class="bg-white p-6 rounded shadow-md max-w-md mx-auto">
        @csrf

        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-semibold mb-2">Título del examen</label>
            <input type="text" name="title" id="title" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-semibold mb-2">Descripción</label>
            <textarea name="description" id="description" rows="3" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded transition">
                Guardar
            </button>
            <a href="{{ route('teacher.exams.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded transition">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection