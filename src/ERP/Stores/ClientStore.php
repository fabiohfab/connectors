<?php

namespace Sinmetro\Connectors\ERP\Stores;

use Sinmetro\Connectors\ERP\Models\Client;

class ClientStore
{
    protected $repository;

    public function __construct(String $erp)
    {
        $namespace = "\\Sinmetro\\Connectors\\ERP\\Repositories\\{$erp}\\ClientRepository";

        $this->repository = new $namespace();
    }

    public function all()
    {
        return $this->repository->all();
    }

    public function get(String $id): Client
    {
        return $this->repository->get($id);
    }

    public function filter(array $filters): array
    {
        return $this->repository->filter($filters);
    }

    public function store(Client $client): Client
    {
        return $this->repository->store($client);
    }

    public function update(array $clients): array
    {
        return $this->repository->update($clients);
    }
}
