<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Exceptions\EmpleadoException;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

/**
 * Controlador para gestión de empleados.
 *
 * Este controlador maneja todas las operaciones CRUD (Crear, Leer, Actualizar, Eliminar)
 * para la entidad Empleado, incluyendo búsqueda y eliminación múltiple.
 *
 * @package App\Http\Controllers
 * @author Equipo de Desarrollo
 * @version 1.0.0
 */
class EmpleadoController extends Controller
{
    /**
     * Muestra una lista paginada de empleados con capacidad de búsqueda.
     *
     * Permite buscar empleados por nombre, email o departamento mediante un parámetro
     * de búsqueda en la URL. Los resultados se paginan de 10 en 10.
     *
     * @param Request $request Objeto de solicitud HTTP que puede contener el parámetro 'search'
     * @return \Illuminate\View\View Vista con la lista de empleados
     * @see Empleado
     */
    public function index(Request $request)
    {
        $query = Empleado::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('departamento', 'like', "%{$search}%");
            });
        }

        $empleados = $query->latest()->paginate(10)->withQueryString();
        return view('empleados.index', compact('empleados'));
    }

    /**
     * Muestra el formulario para crear un nuevo empleado.
     *
     * Renderiza la vista con el formulario de creación de empleado que incluye
     * campos para nombre, email, departamento y salario.
     *
     * @return \Illuminate\View\View Vista del formulario de creación
     */
    public function create()
    {
        return view('empleados.create');
    }

    /**
     * Almacena un nuevo empleado en la base de datos.
     *
     * Valida los datos recibidos del formulario y crea un nuevo registro de empleado.
     * Maneja excepciones de duplicación de email y errores de base de datos.
     *
     * @param Request $request Objeto de solicitud con los datos del empleado
     * @return \Illuminate\Http\RedirectResponse Redirección a la lista de empleados con mensaje de éxito o error
     * @throws EmpleadoException Si el email está duplicado o hay error en la creación
     * @throws QueryException Si hay error de base de datos
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required',
                'email' => 'required|email|unique:empleados,email',
                'departamento' => 'required',
                'salario' => 'required|numeric',
            ]);

            Empleado::create($validated);

            return redirect()->route('empleados.index')
                             ->with('status', 'Empleado creado exitosamente.');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                throw EmpleadoException::emailDuplicado($request->email);
            }
            throw EmpleadoException::errorAlCrear($e->getMessage());
        } catch (\Exception $e) {
            return redirect()->route('empleados.create')
                             ->withInput()
                             ->with('error', $e->getMessage());
        }
    }

    /**
     * Muestra los detalles de un empleado específico.
     *
     * Utiliza route model binding de Laravel para obtener automáticamente
     * el empleado por su ID desde la URL.
     *
     * @param Empleado $empleado Instancia del empleado obtenida automáticamente por Laravel
     * @return \Illuminate\View\View Vista con los detalles del empleado
     */
    public function show(Empleado $empleado)
    {
        return view('empleados.show', compact('empleado'));
    }

    /**
     * Muestra el formulario para editar un empleado existente.
     *
     * Renderiza el formulario de edición pre-llenado con los datos actuales
     * del empleado seleccionado.
     *
     * @param Empleado $empleado Instancia del empleado a editar
     * @return \Illuminate\View\View Vista del formulario de edición con los datos del empleado
     */
    public function edit(Empleado $empleado)
    {
        return view('empleados.edit', compact('empleado'));
    }

    /**
     * Actualiza los datos de un empleado existente.
     *
     * Valida los datos recibidos y actualiza el registro del empleado en la base de datos.
     * La validación de email único excluye el ID del empleado actual.
     * Maneja excepciones de duplicación y errores de base de datos.
     *
     * @param Request $request Objeto de solicitud con los datos actualizados
     * @param Empleado $empleado Instancia del empleado a actualizar
     * @return \Illuminate\Http\RedirectResponse Redirección a la lista con mensaje de éxito o error
     * @throws EmpleadoException Si el email está duplicado o hay error en la actualización
     * @throws QueryException Si hay error de base de datos
     */
    public function update(Request $request, Empleado $empleado)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required',
                'email' => 'required|email|unique:empleados,email,' . $empleado->id,
                'departamento' => 'required',
                'salario' => 'required|numeric',
            ]);

            $empleado->update($validated);

            return redirect()->route('empleados.index')
                             ->with('status', 'Empleado actualizado exitosamente.');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                throw EmpleadoException::emailDuplicado($request->email);
            }
            throw EmpleadoException::errorAlActualizar($e->getMessage());
        } catch (\Exception $e) {
            return redirect()->route('empleados.edit', $empleado)
                             ->withInput()
                             ->with('error', $e->getMessage());
        }
    }

    /**
     * Elimina un empleado de la base de datos.
     *
     * Ejecuta la eliminación del registro del empleado.
     * Maneja restricciones de integridad referencial y otros errores de base de datos.
     *
     * @param Empleado $empleado Instancia del empleado a eliminar
     * @return \Illuminate\Http\RedirectResponse Redirección a la lista con mensaje de éxito o error
     * @throws EmpleadoException Si hay restricciones de base de datos que impiden la eliminación
     * @throws QueryException Si hay error de base de datos
     */
    public function destroy(Empleado $empleado)
    {
        try {
            $empleado->delete();

            return redirect()->route('empleados.index')
                             ->with('status', 'Empleado eliminado exitosamente.');
        } catch (QueryException $e) {
            throw EmpleadoException::errorAlEliminar('No se puede eliminar el empleado debido a restricciones de base de datos.');
        } catch (\Exception $e) {
            return redirect()->route('empleados.index')
                             ->with('error', $e->getMessage());
        }
    }

    /**
     * Elimina múltiples empleados de forma simultánea.
     *
     * Recibe un array de IDs de empleados y los elimina en una sola operación.
     * Valida que todos los IDs existan en la base de datos antes de eliminar.
     * Retorna el número de empleados eliminados.
     *
     * @param Request $request Objeto de solicitud que debe contener un array 'empleados' con los IDs
     * @return \Illuminate\Http\RedirectResponse Redirección con mensaje indicando cantidad eliminada o error
     * @throws EmpleadoException Si no hay empleados seleccionados o hay error en la eliminación
     * @throws \Illuminate\Validation\ValidationException Si los IDs no son válidos
     * @throws QueryException Si hay error de base de datos
     */
    public function destroyMultiple(Request $request)
    {
        try {
            $validated = $request->validate([
                'empleados' => 'required|array',
                'empleados.*' => 'exists:empleados,id',
            ]);

            if (empty($validated['empleados'])) {
                throw EmpleadoException::ningunEmpleadoSeleccionado();
            }

            $count = Empleado::whereIn('id', $validated['empleados'])->delete();

            return redirect()->route('empleados.index')
                             ->with('status', "Se eliminaron {$count} empleado(s) exitosamente.");
        } catch (QueryException $e) {
            throw EmpleadoException::errorEliminacionMultiple('Error de base de datos al eliminar empleados.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('empleados.index')
                             ->with('error', 'Debe seleccionar al menos un empleado válido.');
        } catch (\Exception $e) {
            return redirect()->route('empleados.index')
                             ->with('error', $e->getMessage());
        }
    }
}
