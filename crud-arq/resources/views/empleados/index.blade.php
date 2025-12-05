@extends('layouts.app')
@section('title', 'Lista de Empleados')
@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold tracking-tight text-gray-900">Lista de Empleados</h1>
            <div class="flex items-center gap-3">
                <form id="deleteSelectedForm" action="{{ route('empleados.destroyMultiple') }}" method="POST" onsubmit="return confirm('¿Eliminar los empleados seleccionados?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" id="deleteSelectedBtn" class="inline-flex items-center rounded-md bg-red-600 px-4 py-2 text-white hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                        Eliminar Seleccionados
                    </button>
                </form>
                <a href="{{ route('empleados.create') }}" class="inline-flex items-center rounded-md bg-gray-900 px-4 py-2 text-white hover:bg-gray-800">Nuevo</a>
            </div>
        </div>

        @if (session('status'))
            <div class="rounded-md bg-green-50 p-4 text-sm text-green-800">{{ session('status') }}</div>
        @endif

        @if (session('error'))
            <div class="rounded-md bg-red-50 p-4 text-sm text-red-800">{{ session('error') }}</div>
        @endif

        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-4">
            <form method="GET" action="{{ route('empleados.index') }}" class="flex items-center gap-3">
                <div class="flex-1">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Buscar por nombre, email o departamento..." 
                        class="w-full p-1 rounded-md border-gray-300 shadow-sm focus:border-gray-900 focus:ring-gray-900"
                    >
                </div>
                <button type="submit" class="inline-flex items-center rounded-md bg-gray-900 px-4 py-2 text-white hover:bg-gray-800">
                    Buscar
                </button>
                @if(request('search'))
                    <a href="{{ route('empleados.index') }}" class="inline-flex items-center rounded-md bg-gray-200 px-4 py-2 text-gray-700 hover:bg-gray-300">
                        Limpiar
                    </a>
                @endif
            </form>
        </div>

        <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left">
                                <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-gray-900 focus:ring-gray-900">
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">ID</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Nombre</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Email</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Departamento</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Salario</th>
                            <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($empleados as $empleado)
                            <tr class="hover:bg-gray-50">
                                <td class="whitespace-nowrap px-4 py-3">
                                    <input type="checkbox" name="empleados[]" value="{{ $empleado->id }}" class="empleado-checkbox rounded border-gray-300 text-gray-900 focus:ring-gray-900" form="deleteSelectedForm">
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-gray-900">{{ $empleado->id }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-700">{{ $empleado->nombre }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-700">{{ $empleado->email }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-700">{{ $empleado->departamento }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-700">${{ number_format($empleado->salario, 2) }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('empleados.show', $empleado) }}" class="text-gray-700 hover:underline">Ver</a>
                                        <a href="{{ route('empleados.edit', $empleado) }}" class="text-gray-700 hover:underline">Editar</a>
                                        <form action="{{ route('empleados.destroy', $empleado) }}" method="POST" onsubmit="return confirm('¿Eliminar este empleado?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            {{ $empleados->links() }}
        </div>
    </div>

    <script>
        // Seleccionar todos los checkboxes
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.empleado-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateDeleteButton();
        });

        // Actualizar estado del botón de eliminar
        document.querySelectorAll('.empleado-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateDeleteButton();
                updateSelectAllCheckbox();
            });
        });

        function updateDeleteButton() {
            const checkedBoxes = document.querySelectorAll('.empleado-checkbox:checked');
            const deleteBtn = document.getElementById('deleteSelectedBtn');
            deleteBtn.disabled = checkedBoxes.length === 0;
        }

        function updateSelectAllCheckbox() {
            const checkboxes = document.querySelectorAll('.empleado-checkbox');
            const checkedBoxes = document.querySelectorAll('.empleado-checkbox:checked');
            const selectAllCheckbox = document.getElementById('selectAll');
            selectAllCheckbox.checked = checkboxes.length === checkedBoxes.length && checkboxes.length > 0;
        }
    </script>
@endsection
