<?php

namespace Sinmetro\Connectors\ERP\Stores;

use Sinmetro\Connectors\ERP\Models\Sales;

class SalesStore
{
    protected $repository;

    public function __construct(String $erp)
    {
        $namespace = "\\Sinmetro\\Connectors\\ERP\\Repositories\\{$erp}\\SalesRepository";

        $this->repository = new $namespace();
    }

    public function all()
    {
        return $this->repository->all();
    }

    public function get(String $id): Sales
    {
        return $this->repository->get($id);
    }

    public function filter(array $filters): array
    {
        return $this->repository->filter($filters);
    }
}
