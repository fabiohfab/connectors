<?php

namespace Sinmetro\Connectors\ERP\Models;

class Budget
{
    protected $client;
    protected $project;
    protected $projectType;
    protected $rows;

    public function __construct(array $budget = null)
    {
        $this->client = $budget["client"];
        $this->project = $budget["project"];
        $this->projectType = $budget["projectType"];
        $this->rows = array();
        foreach ($budget["rows"] as $row) {
            array_push($this->rows, new BudgetRow($row));
        }
    }

    public function client()
    {
        return $this->client;
    }

    public function project()
    {
        return $this->project;
    }

    public function projectType()
    {
        return $this->projectType;
    }

    public function rows()
    {
        return $this->rows;
    }

    public function toArray()
    {
        return [
           "client" => $this->client(),
           "project" => $this->project(),
           "projectType" => $this->projectType(),
           "rows" => $this->rows(),
        ];
    }

    public function __toString()
    {
        return $this->client().' '.$this->project();
    }
}
