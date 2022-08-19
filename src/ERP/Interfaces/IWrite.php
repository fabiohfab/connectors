<?php

namespace Sinmetro\Connectors\ERP\Interfaces;

interface IWrite
{
    public static function store(object $client): object;
    public static function update(array $clients): array;
}
