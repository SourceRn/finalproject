@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Submisiones del examen: {{ $exam->title }}</h1>

    <a href="{{ route('teacher.exams.index') }}" class="inline-block bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded mb-6 transition">
        Volver
    </a>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded shadow">
            <thead>
                <tr>
                    <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Estudiante</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Fecha de envío</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($submissions as $submission)
                    <tr class="hover:bg-gray-100">
                        <td class="px-6 py-4 border-b border-gray-200">{{ $submission->user->name }}</td>
                        <td class="px-6 py-4 border-b border-gray-200">
                            {{ \Carbon\Carbon::parse($submission->created_at)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 border-b border-gray-200">
                            <a href="{{ route('teacher.exams.submissions.show', [$exam->id, $submission->id]) }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-2 px-3 rounded transition">
                                Ver detalles
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection