@extends('layouts.app')
@section('title', 'Ver Empleado')
@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold">Detalles del Empleado</h1>
            <div class="inline-flex items-center gap-2">
                <a href="{{ route('empleados.edit', $empleado) }}" class="inline-flex items-center rounded-md bg-gray-900 px-4 py-2 text-white hover:bg-gray-800">Editar</a>
                <a href="{{ route('empleados.index') }}" class="text-gray-700 hover:underline">Volver</a>
            </div>
        </div>

        <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="px-6 py-5 space-y-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">ID</h3>
                    <p class="mt-1 text-base text-gray-900">{{ $empleado->id }}</p>
                </div>
                <div class="border-t border-gray-100 pt-4">
                    <h3 class="text-sm font-medium text-gray-500">Nombre</h3>
                    <p class="mt-1 text-base text-gray-900">{{ $empleado->nombre }}</p>
                </div>
                <div class="border-t border-gray-100 pt-4">
                    <h3 class="text-sm font-medium text-gray-500">Email</h3>
                    <p class="mt-1 text-base text-gray-900">{{ $empleado->email }}</p>
                </div>
                <div class="border-t border-gray-100 pt-4">
                    <h3 class="text-sm font-medium text-gray-500">Departamento</h3>
                    <p class="mt-1 text-base text-gray-900">{{ $empleado->departamento }}</p>
                </div>
                <div class="border-t border-gray-100 pt-4">
                    <h3 class="text-sm font-medium text-gray-500">Salario</h3>
                    <p class="mt-1 text-base text-gray-900">${{ number_format($empleado->salario, 2) }}</p>
                </div>
                <div class="border-t border-gray-100 pt-4">
                    <h3 class="text-sm font-medium text-gray-500">Fecha de Creación</h3>
                    <p class="mt-1 text-base text-gray-900">{{ $empleado->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="border-t border-gray-100 pt-4">
                    <h3 class="text-sm font-medium text-gray-500">Última Actualización</h3>
                    <p class="mt-1 text-base text-gray-900">{{ $empleado->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <form action="{{ route('empleados.destroy', $empleado) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este empleado?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center rounded-md bg-red-600 px-4 py-2 text-white hover:bg-red-700">Eliminar Empleado</button>
        </form>
    </div>
@endsection
