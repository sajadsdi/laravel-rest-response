<?php

namespace Sajadsdi\LaravelRestResponse\Concerns;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Sajadsdi\LaravelRestResponse\Contracts\CrudRepositoryInterface;

trait CrudApi
{

    /**
     * You can implement CrudRepositoryInterface for your model or repository instance.
     *
     * @var CrudRepositoryInterface
     */
    public CrudRepositoryInterface $repository;


    /**
     * @param array $validated_data
     * @return Response|ResponseFactory
     */
    public function createOperation(array $validated_data): Response|ResponseFactory
    {
        if ($create = $this->repository->create($validated_data)) {
            return $this->createResponse($create);
        }

        return $this->badRequestResponse();
    }

    /**
     * @param string|int $validated_id
     * @return Response|ResponseFactory
     */
    public function readOperation(string|int $validated_id): Response|ResponseFactory
    {
        if ($read = $this->repository->read($validated_id)) {
            return $this->response($read);
        }

        return $this->notFoundResponse();
    }

    /**
     * @param string|int $validated_id
     * @param array $validated_data
     * @return Response|ResponseFactory
     */
    public function updateOperation(string|int $validated_id, array $validated_data): Response|ResponseFactory
    {
        if ($update = $this->repository->update($validated_id, $validated_data)) {
            return $this->updateResponse($update);
        }

        return $this->notFoundResponse();
    }

    /**
     * @param string|int $validated_id
     * @return Response|ResponseFactory
     */
    public function deleteOperation(string|int $validated_id): Response|ResponseFactory
    {
        if ($this->repository->delete($validated_id)) {
            return $this->deleteResponse();
        }

        return $this->notFoundResponse();
    }

    /**
     * This
     * @param int $perPage
     * @param string|null $search
     * @param string|null $filter
     * @param string|null $sort
     * @return Response|ResponseFactory
     */
    public function indexOperation(string $search = null, string $filter = null, string $sort = null, int $perPage = 15): Response|ResponseFactory
    {
        return $this->response($this->repository->index($search, $filter, $sort, $perPage));
    }
}
