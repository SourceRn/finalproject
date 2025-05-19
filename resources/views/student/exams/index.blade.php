@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Exámenes Disponibles</h1>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if ($exams->isEmpty())
        <p class="text-gray-600">No hay exámenes disponibles por el momento.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded shadow">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase">Título</th>
                        <th class="px-6 py-3 border-b bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase">Descripción</th>
                        <th class="px-6 py-3 border-b bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase">Profesor</th>
                        <th class="px-6 py-3 border-b bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase">Estado</th>
                        <th class="px-6 py-3 border-b bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($exams as $exam)
                        @php
                            $submission = $exam->submissions->first(); // Solo una por usuario
                        @endphp
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4 border-b border-gray-200">{{ $exam->title }}</td>
                            <td class="px-6 py-4 border-b border-gray-200">{{ $exam->description }}</td>
                            <td class="px-6 py-4 border-b border-gray-200">{{ $exam->teacher->name }}</td>
                            <td class="px-6 py-4 border-b border-gray-200">
                                @if ($submission)
                                    <span class="text-green-700 font-semibold">Completado ({{ $submission->score }} pts)</span>
                                @else
                                    <span class="text-gray-600 italic">Pendiente</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200">
                                @if (!$submission)
                                    <a href="{{ route('student.exams.show', $exam->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-2 px-3 rounded">
                                        Ver / Responder
                                    </a>
                                @else
                                    <button class="bg-gray-400 text-white text-xs font-semibold py-2 px-3 rounded cursor-not-allowed" disabled>
                                        Ya enviado
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection