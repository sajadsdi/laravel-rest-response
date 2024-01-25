<?php

namespace Sajadsdi\LaravelRestResponse\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Sajadsdi\LaravelRestResponse\Concerns\RestResponse;

class BaseRequest extends FormRequest
{
    use RestResponse;

    private ?string $AuthorizeError = null;

    protected function failedAuthorization()
    {
        throw new HttpResponseException($this->forbiddenResponse($this->AuthorizeError ?? 'You do not have the necessary permissions for this action.'));
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->getMessageBag();

        throw new HttpResponseException($this->response([], 'Validation error!', $errors->getMessages(), 422));
    }

    protected function setAuthorizeError(string $massage)
    {
        $this->AuthorizeError = $massage;
    }
}
