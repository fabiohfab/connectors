<?php

namespace Sinmetro\Connectors\ERP\Stores;

use Sinmetro\Connectors\ERP\Models\Order;

class OrderStore
{
    protected $repository;

    public function __construct(String $erp)
    {
        $namespace = "\\Sinmetro\\Connectors\\ERP\\Repositories\\{$erp}\\OrderRepository";

        $this->repository = new $namespace();
    }

    public function all()
    {
        return $this->repository->all();
    }

    public function get(String $id): Order
    {
        return $this->repository->get($id);
    }

    public function filter(array $filters): array
    {
        return $this->repository->filter($filters);
    }

    public function store(Order $order): Order
    {
        return $this->repository->store($order);
    }

    public function update(array $orders): array
    {
        return $this->repository->update($orders);
    }

    public function delete(String $id): void
    {
        $this->repository->delete($id);
    }

    public function cancel(String $id): array
    {
        return $this->repository->cancel($id);
    }
}
