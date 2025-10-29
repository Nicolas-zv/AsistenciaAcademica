<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DocenteRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a hacer esta solicitud.
     */
    public function authorize(): bool
    {
        // Asume que solo un usuario autenticado y con permisos (ej: administrador) puede crear docentes.
        return true; 
    }

    /**
     * Obtiene las reglas de validación que se aplican a la solicitud.
     */
    public function rules(): array
    {
        // 🚀 CRÍTICO: Reglas adaptadas a tu clave primaria personalizada (correo)
        return [
            // El 'user_id' debe ser el CORREO (string)
            'user_id' => [
                'required',
                'string',
                // 1. Debe existir en la columna 'correo' de la tabla 'users'.
                'exists:users,correo', 
                // 2. No debe existir aún en la columna 'user_id' de la tabla 'docentes'.
                Rule::unique('docentes', 'user_id'), 
            ],
            // El código es opcional pero debe ser único si se proporciona.
            'codigo' => [
                'nullable', 
                'string', 
                'max:255', 
                Rule::unique('docentes', 'codigo'),
            ],
            'fecha_contrato' => 'nullable|date',
            'carga_horaria' => 'required|integer|min:0|max:40',
            'especialidad' => 'nullable|string|max:255',
            'categoria' => 'nullable|string|max:255',
        ];
    }

    /**
     * Personaliza los mensajes de error.
     */
    public function messages(): array
    {
        return [
            'user_id.unique' => 'El usuario seleccionado ya tiene un perfil docente asignado.',
            'user_id.exists' => 'El usuario seleccionado no existe o es inválido.',
            'codigo.unique' => 'Este código docente ya está en uso. Por favor, ingrese uno diferente.',
            // Puedes añadir más mensajes personalizados aquí...
        ];
    }
}