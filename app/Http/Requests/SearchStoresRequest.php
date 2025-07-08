<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchStoresRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'n' => 'required|numeric|between:-90,90',
            's' => 'required|numeric|between:-90,90',
            'e' => 'required|numeric|between:-180,180',
            'w' => 'required|numeric|between:-180,180',
            'services' => 'array',
            'services.*' => 'integer|exists:services,id',
            'operator' => 'in:AND,OR',
        ];
    }

    public function messages(): array
    {
        return [
            'n.required' => 'La latitude nord est requise.',
            'n.numeric' => 'La latitude nord doit être un nombre.',
            'n.between' => 'La latitude nord doit être entre -90 et 90.',
            's.required' => 'La latitude sud est requise.',
            's.numeric' => 'La latitude sud doit être un nombre.',
            's.between' => 'La latitude sud doit être entre -90 et 90.',
            'e.required' => 'La longitude est est requise.',
            'e.numeric' => 'La longitude est doit être un nombre.',
            'e.between' => 'La longitude est doit être entre -180 et 180.',
            'w.required' => 'La longitude ouest est requise.',
            'w.numeric' => 'La longitude ouest doit être un nombre.',
            'w.between' => 'La longitude ouest doit être entre -180 et 180.',
            'services.array' => 'Les services doivent être une liste.',
            'services.*.integer' => 'Chaque service doit être un identifiant valide.',
            'services.*.exists' => 'Un des services sélectionnés n\'existe pas.',
            'operator.in' => 'L\'opérateur doit être AND ou OR.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $n = $this->input('n');
            $s = $this->input('s');
            $e = $this->input('e');
            $w = $this->input('w');

            if ($n <= $s) {
                $validator->errors()->add('n', 'La latitude nord doit être supérieure à la latitude sud.');
            }

            if ($e <= $w) {
                $validator->errors()->add('e', 'La longitude est doit être supérieure à la longitude ouest.');
            }
        });
    }
}
