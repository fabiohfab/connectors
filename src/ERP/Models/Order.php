<?php

namespace Sinmetro\Connectors\ERP\Models;

use Sinmetro\Connectors\ERP\Models\OrderRow;

class Order
{
    protected $supplier;
    protected $documentDate;
    protected $discount;
    protected $reference;
    protected $externalId;
    protected $rows;

    public function __construct(array $order = null)
    {
        $this->supplier = $order["supplier"];
        $this->documentDate = $order["documentDate"];
        $this->discount = $order["discount"];
        $this->reference = $order["reference"];
        $this->externalId = $order["externalId"];
        $this->rows = array();
        foreach ($order["rows"] as $row) {
            array_push($this->rows, new OrderRow($row));
        }
    }

    public function supplier()
    {
        return $this->supplier;
    }

    public function documentDate()
    {
        return $this->documentDate;
    }

    public function discount()
    {
        return $this->discount;
    }

    public function reference()
    {
        return $this->reference;
    }

    public function externalId()
    {
        return $this->externalId;
    }

    public function rows()
    {
        return $this->rows;
    }

    public function toArray()
    {
        return [
          "supplier" => $this->supplier(),
          "documentDate" => $this->documentDate(),
          "discount" => $this->discount(),
          "reference" => $this->reference(),
          "externalId" => $this->externalId(),
          "rows" => $this->rows(),
        ];
    }

    public function __toString()
    {
        return $this->supplier().' '.$this->documentDate();
    }
}
