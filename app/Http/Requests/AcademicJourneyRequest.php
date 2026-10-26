<?php

namespace App\Http\Requests;

use App\Models\AcademicJourney;
use Illuminate\Foundation\Http\FormRequest;

class AcademicJourneyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('academic_journey') ? (int) $this->route('academic_journey') : null;
        return AcademicJourney::validationRules($id);
    }
}
