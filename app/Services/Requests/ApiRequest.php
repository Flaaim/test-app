<?php 

namespace App\Services\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\Response\ResponseService;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiRequest extends FormRequest
{
    
   protected function failedValidation(Validator $validator)
   {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(ResponseService::sendJsonResponse(
            false,
            403,
            $errors
        ));
                   
   }
}