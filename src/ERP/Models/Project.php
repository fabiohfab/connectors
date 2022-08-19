<?php

namespace Sinmetro\Connectors\ERP\Models;

use Sinmetro\Connectors\ERP\Models\Client;

class Project
{
    public function __construct(array $project = null)
    {
        $this->code = $project["code"];
        $this->description = $project["description"];
        $this->client = new Client($project["client"]);
        $this->observations = $project["observations"];
        $this->predictionStartDate = $project["predictionStartDate"];
        $this->predictionEndDate = $project["predictionEndDate"];
        $this->state = $project["state"];
        $this->projectType = $project["projectType"];
        $this->projectSource = $project["projectSource"];
        $this->cavitiesNumber = $project["cavitiesNumber"];
        $this->draw = $project["draw"];
        $this->manufacturer = $project["manufacturer"];
        $this->piece = $project["piece"];
        $this->orderDate = $project["orderDate"];
        $this->orderNumber = $project["orderNumber"];
        $this->value = $project["value"];
        $this->budgetValue = $project["budgetValue"];
        $this->budget = $project["budget"];
        $this->updatedAt = $project["updatedAt"];
        $this->updatedBy = $project["updatedBy"];
        $this->budgetId = $project["budgetId"];
        $this->projectTypeName = $project["projectTypeName"];
        $this->newRepairs = $project["newRepairs"];
        $this->project = $project["project"];
        $this->molde = $project["molde"];
    }

    public function code()
    {
        return $this->code;
    }

    public function description()
    {
        return $this->description;
    }

    public function client()
    {
        return $this->client;
    }

    public function observations()
    {
        return $this->observations;
    }

    public function predictionStartDate()
    {
        return $this->predictionStartDate;
    }

    public function predictionEndDate()
    {
        return $this->predictionEndDate;
    }

    public function state()
    {
        return $this->state;
    }

    public function projectType()
    {
        return $this->projectType;
    }

    public function projectSource()
    {
        return $this->projectSource;
    }

    public function cavitiesNumber()
    {
        return $this->cavitiesNumber;
    }

    public function draw()
    {
        return $this->draw;
    }

    public function manufacturer()
    {
        return $this->manufacturer;
    }

    public function piece()
    {
        return $this->piece;
    }

    public function orderDate()
    {
        return $this->orderDate;
    }

    public function orderNumber()
    {
        return $this->orderNumber;
    }

    public function value()
    {
        return $this->value;
    }

    public function budgetValue()
    {
        return $this->budgetValue;
    }

    public function quantity()
    {
        return $this->quantity;
    }

    public function budget()
    {
        return $this->budget;
    }

    public function updatedAt()
    {
        return $this->updatedAt;
    }

    public function updatedBy()
    {
        return $this->updatedBy;
    }

    public function budgetId()
    {
        return $this->budgetId;
    }

    public function projectTypeName()
    {
        return $this->projectTypeName;
    }

    public function newRepairs()
    {
        return $this->newRepairs;
    }

    public function project()
    {
        return $this->project;
    }

    public function molde()
    {
        return $this->molde;
    }

    public function toArray()
    {
        return [
          "code" => $this->code(),
          "description" => $this->description(),
          "client" => $this->client(),
          "observations" => $this->observations(),
          "predictionStartDate" => $this->predictionStartDate(),
          "predictionEndDate" => $this->predictionEndDate(),
          "state" => $this->state(),
          "projectType" => $this->projectType(),
          "projectSource" => $this->projectSource(),
          "cavitiesNumber" => $this->cavitiesNumber(),
          "draw" => $this->draw(),
          "manufacturer" => $this->manufacturer(),
          "piece" => $this->piece(),
          "orderDate" => $this->orderDate(),
          "orderNumber" => $this->orderNumber(),
          "value" => $this->value(),
          "budgetValue" => $this->budgetValue(),
          "budget" => $this->budget(),
          "updatedAt" => $this->updatedAt(),
          "updatedBy" => $this->updatedBy(),
          "budgetId" => $this->budgetId(),
          "projectTypeName" => $this->projectTypeName(),
          "newRepairs" => $this->newRepairs(),
          "project" => $this->project(),
          "molde" => $this->molde(),
        ];
    }

    public function __toString()
    {
        return $this->code();
    }
}
