<?php

namespace Sinmetro\Connectors\ERP\Models;

class Country
{
    protected $id;
    protected $description;

    public function __construct(array $country = null)
    {
        foreach ($country as $key => $value) {
            $this->$key = $value;
        }
    }
    public function get($name)
    {
        return $this->$name;
    }

    public function id()
    {
        return $this->id;
    }

    public function description()
    {
        return $this->description;
    }

    public function toArray()
    {
        return [
            "id" => $this->id(),
            "description" => $this->description(),
        ];
    }

    public function __toString()
    {
        return $this->id();
    }
}
