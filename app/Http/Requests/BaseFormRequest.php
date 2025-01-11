<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Redirector;

class BaseFormRequest extends FormRequest
{
    public function convertRequest(string $request_class): BaseFormRequest
    {
        $Request = $request_class::createFrom($this);

        $app = app();
        $Request
            ->setContainer($app)
            ->setRedirector($app->make(Redirector::class));

        $Request->prepareForValidation();
        $Request->getValidatorInstance();

        return $Request;
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }
}
