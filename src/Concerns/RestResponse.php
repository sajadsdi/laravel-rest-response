<?php
namespace Sajadsdi\LaravelRestResponse\Concerns;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

trait RestResponse
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
     * @param mixed $data
     * @param string $message
     * @param array $errors
     * @param int $status
     * @return Response|ResponseFactory
     */
    public function response(mixed $data = [], string $message = 'Success!', array $errors = [], int $status = 200): Response|ResponseFactory
    {
        return response([
            'data'    => $data,
            'message' => $message,
            'errors'  => (object)$errors,
            'status'  => $status,
            'version' => $this->getVersion()
        ], $status);
    }

    /**
     * Generates a response for successful creation with the provided data and message.
     *
     * @param mixed $data
     * @param string $message
     * @return Response|ResponseFactory
     */
    public function createResponse(mixed $data = [], string $message = 'Create success!'): Response|ResponseFactory
    {
        return $this->response($data, $message, [], 201);
    }

    /**
     * Generates a response for successful update with the provided data and message.
     *
     * @param mixed $data
     * @param string $message
     * @return Response|ResponseFactory
     */
    public function updateResponse(mixed $data = [], string $message = 'Update success!'): Response|ResponseFactory
    {
        return $this->response($data, $message, []);
    }

    /**
     * Generates a response for successful deletion.
     *
     * @return Response|ResponseFactory
     */
    public function deleteResponse(): Response|ResponseFactory
    {
        return response(null,204);
    }

    /**
     * Generates a response for a not found resource with the provided message and errors.
     *
     * @param string $message
     * @param array $errors
     * @return Response|ResponseFactory
     */
    public function notFoundResponse(string $message = 'Source not found!', array $errors = []): Response|ResponseFactory
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
    public function forbiddenResponse(string $message = 'Forbidden!', array $errors = []): Response|ResponseFactory
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
    public function unauthorizedResponse(string $message = 'Unauthorized!', array $errors = []): Response|ResponseFactory
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
