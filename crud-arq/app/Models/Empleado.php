<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Modelo de Empleado.
 *
 * Representa la entidad de empleado en el sistema con sus atributos básicos
 * como nombre, email, departamento y salario. Implementa el patrón Active Record
 * mediante Eloquent ORM de Laravel.
 *
 * @package App\Models
 * @property int $id Identificador único del empleado
 * @property string $nombre Nombre completo del empleado
 * @property string $email Correo electrónico único del empleado
 * @property string $departamento Departamento al que pertenece el empleado
 * @property float $salario Salario del empleado en formato decimal
 * @property \Illuminate\Support\Carbon $created_at Fecha y hora de creación del registro
 * @property \Illuminate\Support\Carbon $updated_at Fecha y hora de última actualización
 * @author Equipo de Desarrollo
 * @version 1.0.0
 */
class Empleado extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'empleados';

    /**
     * Atributos asignables en masa.
     *
     * Define qué campos pueden ser asignados mediante create() o fill().
     * Protege contra asignación masiva de campos no deseados.
     *
     * @var array<string>
     */
    protected $fillable = [
        'nombre',
        'email',
        'departamento',
        'salario',
    ];

    /**
     * Atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'salario' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
