<?php

namespace Sinmetro\Connectors\ERP\Stores;

use Sinmetro\Connectors\ERP\Models\Budget;

class BudgetStore
{
    protected $repository;

    public function __construct(String $erp)
    {
        $namespace = "\\Sinmetro\\Connectors\\ERP\\Repositories\\{$erp}\\BudgetRepository";

        $this->repository = new $namespace();
    }

    public function all()
    {
        return $this->repository->all();
    }

    public function get(String $id): Budget
    {
        return $this->repository->get($id);
    }

    public function filter(array $filters): array
    {
        return $this->repository->filter($filters);
    }

    public function store(Budget $budget): Budget
    {
        return $this->repository->store($budget);
    }

    public function update(array $budgets): array
    {
        return $this->repository->update($budgets);
    }

    public function delete(String $id): void
    {
        $this->repository->delete($id);
    }

    public function cancelByProject(String $project): array
    {
        return $this->repository->cancelByProject($project);
    }
}
