<?php

namespace App\Http\Requests\Api;

use App\Models\Generation;

class GenerationCreateRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'type'   => 'nullable|string|in:'.implode(',', Generation::SUPPORTED_TYPES),
            'length' => 'nullable|numeric',
            'values' => 'nullable|array|required_if:type,'.Generation::TYPE_SET_VALUE,
        ];
    }

    public function messages() : array
    {
        return [
            'type.string'        => 'Поле тип должно быть строкой.',
            'type.in'            => 'Неверный тип генерации.',
            'length.numeric'     => 'Длина строки должна быть строкой.',
            'values.array'       => 'Заданные значения должны быть массивом.',
            'values.required_if' => 'Необходимо передать заданные значения.'
        ];
    }
}
