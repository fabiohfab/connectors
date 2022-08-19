<?php

namespace Sinmetro\Connectors\ERP\Models;

class Country
{
    protected $id;
    protected $description;

    public function __construct(array $client = null)
    {
        $this->id = $client["id"];
        $this->description = $client["description"];
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
