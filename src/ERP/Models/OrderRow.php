<?php

namespace Sinmetro\Connectors\ERP\Models;

class OrderRow
{
    protected $article;
    protected $description;
    protected $quantity;
    protected $discount;
    protected $unitPrice;
    protected $totalNet;
    protected $total;
    protected $project;
    protected $groupingDimension;
    protected $groupingType;
    protected $externalId;
    protected $deliveryDate;

    public function __construct(array $order = null)
    {
        $this->article = $order["article"];
        $this->description = $order["description"];
        $this->quantity = $order["quantity"];
        $this->discount = $order["discount"];
        $this->unitPrice = $order["unitPrice"];
        $this->totalNet = $order["totalNet"];
        $this->total = $order["total"];
        $this->project = $order["project"];
        $this->groupingDimension = $order["groupingDimension"];
        $this->groupingType = $order["groupingType"];
        $this->externalId = $order["externalId"];
        $this->deliveryDate = $order["deliveryDate"];
    }

    public function article()
    {
        return $this->article;
    }

    public function description()
    {
        return $this->description;
    }

    public function quantity()
    {
        return $this->article;
    }

    public function discount()
    {
        return $this->discount;
    }

    public function unitPrice()
    {
        return $this->unitPrice;
    }

    public function totalNet()
    {
        return $this->totalNet;
    }

    public function total()
    {
        return $this->total;
    }

    public function project()
    {
        return $this->project;
    }

    public function groupingDimension()
    {
        return $this->groupingDimension;
    }

    public function groupingType()
    {
        return $this->groupingType;
    }

    public function externalId()
    {
        return $this->externalId;
    }

    public function deliveryDate()
    {
        return $this->deliveryDate;
    }

    public function toArray()
    {
        return [
            "article" => $this->article(),
            "description" => $this->description(),
            "quantity" => $this->quantity(),
            "discount" => $this->discount(),
            "unitPrice" => $this->unitPrice(),
            "totalNet" => $this->totalNet(),
            "total" => $this->total(),
            "project" => $this->project(),
            "groupingDimension" => $this->groupingDimension(),
            "groupingType" => $this->groupingType(),
            "externalId" => $this->externalId(),
            "deliveryDate" => $this->deliveryDate(),
        ];
    }

    public function __toString()
    {
        return $this->article().' '.$this->description();
    }
}
