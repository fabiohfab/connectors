<?php

namespace Sinmetro\Connectors\ERP\Models;

class BudgetRow
{
    protected $id;
    protected $value;
    protected $quantity;
    protected $description;

    public function __construct(array $budgetRow = null)
    {
        $this->id = $budgetRow["id"];
        $this->value = $budgetRow["value"];
        $this->quantity = $budgetRow["quantity"];
        $this->description = $budgetRow["description"];
    }

    public function id()
    {
        return $this->id;
    }

    public function value()
    {
        return $this->value;
    }

    public function quantity()
    {
        return $this->quantity;
    }

    public function description()
    {
        return $this->description;
    }

    public function toArray()
    {
        return [
           "id" => $this->id(),
           "value" => $this->value(),
           "quantity" => $this->quantity(),
           "description" => $this->description(),
        ];
    }

    public function __toString()
    {
        return $this->id();
    }
}
