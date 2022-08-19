<?php

namespace Sinmetro\Connectors\ERP\Stores;

use Sinmetro\Connectors\ERP\Models\Purchasing;

class PurchasingStore
{
    protected $repository;

    public function __construct(String $erp)
    {
        $namespace = "\\Sinmetro\\Connectors\\ERP\\Repositories\\{$erp}\\PurchasingRepository";

        $this->repository = new $namespace();
    }

    public function all()
    {
        return $this->repository->all();
    }

    public function get(String $id): Purchasing
    {
        return $this->repository->get($id);
    }

    public function filter(array $filters): array
    {
        return $this->repository->filter($filters);
    }
}
