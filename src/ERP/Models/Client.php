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
        $this->id = $client["id"];
        $this->name = $client["name"];
        $this->vatID = $client["vatID"];
        $this->address = $client["address"];
        $this->zipCode = $client["zipCode"];
        $this->city = $client["city"];
        $this->phoneNumber = $client["phoneNumber"];
        $this->phoneNumber2 = $client["phoneNumber2"];
        $this->fax = $client["fax"];
        $this->notes = $client["notes"];
        $this->coin = new Coin($client["coin"]);
        $this->country = new Country($client["country"]);
        $this->paymentMethod = $client["paymentMethod"];
        $this->shippingMethod = $client["shippingMethod"];
        $this->paymentCondition = $client["paymentCondition"];
        $this->crm = $client["crm"];
        $this->fiscalSpace = $client["fiscalSpace"];
    }

    public function id()
    {
        return $this->id;
    }

    public function name()
    {
        return $this->name;
    }

    public function vatId()
    {
        return $this->vatID;
    }

    public function address()
    {
        return $this->address;
    }

    public function zipCode()
    {
        return $this->zipCode;
    }

    public function city()
    {
        return $this->city;
    }

    public function phoneNumber()
    {
        return $this->phoneNumber;
    }

    public function phoneNumber2()
    {
        return $this->phoneNumber2;
    }

    public function fax()
    {
        return $this->fax;
    }

    public function notes()
    {
        return $this->notes;
    }

    public function coin()
    {
        return $this->coin;
    }

    public function country()
    {
        return $this->country;
    }

    public function paymentMethod()
    {
        return $this->paymentMethod;
    }

    public function shippingMethod()
    {
        return $this->shippingMethod;
    }

    public function paymentCondition()
    {
        return $this->paymentCondition;
    }

    public function crm()
    {
        return $this->crm;
    }

    public function fiscalSpace()
    {
        return $this->fiscalSpace;
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
