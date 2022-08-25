<?php

namespace Sinmetro\Connectors\ERP\Models;

use Sinmetro\Connectors\ERP\Models\Coin;
use Sinmetro\Connectors\ERP\Models\Country;

class Client
{
    protected $id;
    protected $name;
    protected $vatID;
    protected $address;
    protected $zipCode;
    protected $city;
    protected $phoneNumber;
    protected $phoneNumber2;
    protected $fax;
    protected $notes;
    protected $coin;
    protected $country;
    protected $paymentMethod;
    protected $shippingMethod;
    protected $paymentCondition;
    protected $crm;
    protected $fiscalSpace;

    public function __construct(array $client = null)
    {
        foreach ($client as $key => $value) {
            $this->$key = $value;
        }
    }
    public function get($name)
    {
        return $this->$name;
    }

    public function toArray()
    {
        return [
           "id" => $this->id(),
           "name" => $this->name(),
           "vatId" => $this->vatID(),
           "address" => $this->address(),
           "zipCode" => $this->zipCode(),
           "city" => $this->city(),
           "phoneNumber" => $this->phoneNumber(),
           "phoneNumber2" => $this->phoneNumber2(),
           "fax" => $this->fax(),
           "notes" => $this->notes(),
           "coin" => $this->coin(),
           "country" => $this->country(),
           "paymentMethod" => $this->paymentMethod(),
           "shippingMethod" => $this->shippingMethod(),
           "paymentCondition" => $this->paymentCondition(),
           "crm" => $this->crm(),
           "fiscalSpace" => $this->fiscalSpace(),
        ];
    }

    public function __toString()
    {
        return $this->id();
    }
}
