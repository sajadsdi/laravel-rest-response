<?php

namespace Sajadsdi\LaravelRestResponse\Http\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

/**
 * Class RestController
 *
 * This class provides a RESTful API response structure for Laravel applications.
 *
 * @package Sajadsdi\LaravelRestResponse\Http\Controllers
 */
class RestController extends Controller
{

    /**
     * Get the version of the api.
     *
     * @return string
     */
    protected function getVersion(): string
    {
        return '1.0.0';
    }

    /**
     * Generates a response with the provided data, message, errors, and status code.
     *
     * @param array $data
     * @param string $message
     * @param array $errors
     * @param int $status
     * @return Response|ResponseFactory
     */
    public function response(array $data = [], string $message = 'success', array $errors = [], int $status = 200): Response|ResponseFactory
    {
        return response([
            'data'    => $data,
            'message' => $message,
            'errors'  => $errors,
            'status'  => $status,
            'version' => $this->getVersion()
        ], $status);
    }

    /**
     * Generates a response for successful creation with the provided data and message.
     *
     * @param array $data
     * @param string $message
     * @return Response|ResponseFactory
     */
    public function createResponse(array $data = [], string $message = 'create success!'): Response|ResponseFactory
    {
        return $this->response($data, $message, [], 201);
    }

    /**
     * Generates a response for successful update with the provided data and message.
     *
     * @param array $data
     * @param string $message
     * @return Response|ResponseFactory
     */
    public function updateResponse(array $data = [], string $message = 'update success!'): Response|ResponseFactory
    {
        return $this->response($data, $message, [], 200);
    }

    /**
     * Generates a response for successful deletion with the provided message.
     *
     * @param string $message
     * @return Response|ResponseFactory
     */
    public function deleteResponse(string $message = 'delete success!'): Response|ResponseFactory
    {
        return $this->response([], $message, [], 204);
    }

    /**
     * Generates a response for a not found resource with the provided message and errors.
     *
     * @param string $message
     * @param array $errors
     * @return Response|ResponseFactory
     */
    public function notFoundResponse(string $message = 'not found!', array $errors = []): Response|ResponseFactory
    {
        return $this->response([], $message, $errors, 404);
    }

    /**
     * Generates a response for forbidden access with the provided message and errors.
     *
     * @param string $message
     * @param array $errors
     * @return Response|ResponseFactory
     */
    public function forbiddenResponse(string $message = 'forbidden!', array $errors = []): Response|ResponseFactory
    {
        return $this->response([], $message, $errors, 403);
    }

    /**
     * Generates a response for unauthorized access with the provided message and errors.
     *
     * @param string $message
     * @param array $errors
     * @return Response|ResponseFactory
     */
    public function unauthorizedResponse(string $message = 'unauthorized!', array $errors = []): Response|ResponseFactory
    {
        return $this->response([], $message, $errors, 401);
    }

    /**
     * Generates a response for a bad request with the provided message and errors.
     *
     * @param string $message
     * @param array $errors
     * @return Response|ResponseFactory
     */
    public function badRequestResponse(string $message = 'bad request!', array $errors = []): Response|ResponseFactory
    {
        return $this->response([], $message, $errors, 400);
    }

}
