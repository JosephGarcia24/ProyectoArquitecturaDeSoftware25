<?php

namespace App\Exceptions;

use Exception;

/**
 * Excepciones personalizadas para operaciones relacionadas con empleados.
 *
 * Esta clase define excepciones específicas del dominio de empleados,
 * proporcionando mensajes descriptivos y códigos HTTP apropiados para
 * diferentes escenarios de error en las operaciones CRUD.
 *
 * @package App\Exceptions
 * @author Equipo de Desarrollo
 * @version 1.0.0
 */
class EmpleadoException extends Exception
{
    /**
     * Crea una excepción cuando no se encuentra un empleado.
     *
     * Utilizada cuando se intenta acceder a un empleado que no existe en la base de datos.
     *
     * @param int|string $id Identificador del empleado que no fue encontrado
     * @return static Instancia de la excepción con código HTTP 404
     */
    public static function noEncontrado($id)
    {
        return new static("El empleado con ID {$id} no fue encontrado.", 404);
    }

    /**
     * Crea una excepción cuando falla la creación de un empleado.
     *
     * Se lanza cuando ocurre un error durante el proceso de inserción de un nuevo empleado.
     *
     * @param string|null $mensaje Mensaje personalizado de error. Si es null, usa mensaje por defecto
     * @return static Instancia de la excepción con código HTTP 500
     */
    public static function errorAlCrear($mensaje = null)
    {
        $msg = $mensaje ?? 'Error al crear el empleado.';
        return new static($msg, 500);
    }

    /**
     * Crea una excepción cuando falla la actualización de un empleado.
     *
     * Se lanza cuando ocurre un error durante el proceso de actualización de datos del empleado.
     *
     * @param string|null $mensaje Mensaje personalizado de error. Si es null, usa mensaje por defecto
     * @return static Instancia de la excepción con código HTTP 500
     */
    public static function errorAlActualizar($mensaje = null)
    {
        $msg = $mensaje ?? 'Error al actualizar el empleado.';
        return new static($msg, 500);
    }

    /**
     * Crea una excepción cuando falla la eliminación de un empleado.
     *
     * Se lanza cuando ocurre un error durante el proceso de eliminación, típicamente
     * por restricciones de integridad referencial en la base de datos.
     *
     * @param string|null $mensaje Mensaje personalizado de error. Si es null, usa mensaje por defecto
     * @return static Instancia de la excepción con código HTTP 500
     */
    public static function errorAlEliminar($mensaje = null)
    {
        $msg = $mensaje ?? 'Error al eliminar el empleado.';
        return new static($msg, 500);
    }

    /**
     * Crea una excepción cuando se intenta registrar un email duplicado.
     *
     * Se lanza cuando se intenta crear o actualizar un empleado con un email
     * que ya existe en la base de datos, violando la restricción de unicidad.
     *
     * @param string $email Correo electrónico que causó el conflicto
     * @return static Instancia de la excepción con código HTTP 422 (Unprocessable Entity)
     */
    public static function emailDuplicado($email)
    {
        return new static("El email {$email} ya está registrado.", 422);
    }

    /**
     * Crea una excepción cuando no se seleccionan empleados para eliminación múltiple.
     *
     * Se lanza cuando el usuario intenta realizar una eliminación múltiple sin
     * haber seleccionado ningún empleado.
     *
     * @return static Instancia de la excepción con código HTTP 422 (Unprocessable Entity)
     */
    public static function ningunEmpleadoSeleccionado()
    {
        return new static('Debe seleccionar al menos un empleado.', 422);
    }

    /**
     * Crea una excepción cuando falla la eliminación múltiple de empleados.
     *
     * Se lanza cuando ocurre un error durante el proceso de eliminación de
     * múltiples empleados simultáneamente.
     *
     * @param string|null $mensaje Mensaje personalizado de error. Si es null, usa mensaje por defecto
     * @return static Instancia de la excepción con código HTTP 500
     */
    public static function errorEliminacionMultiple($mensaje = null)
    {
        $msg = $mensaje ?? 'Error al eliminar los empleados seleccionados.';
        return new static($msg, 500);
    }
}
