<?php

namespace App\Http\Requests;

use App\Exceptions\UnauthenticatedException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

abstract class Request extends FormRequest
{
    /**
     * Handle a failed authorization attempt.
     *
     * @throws \App\Exceptions\UnauthenticatedException
     */
    protected function failedAuthorization()
    {
        throw new UnauthenticatedException();
    }

    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array  $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        return new JsonResponse($errors, 422);
    }
}
