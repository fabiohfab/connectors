<?php

namespace Sinmetro\Connectors\ERP\Models;

class Coin
{
    protected $id;
    protected $description;

    public function __construct(array $coin = null)
    {
        foreach ($coin as $key => $value) {
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
