<?php

namespace Sinmetro\Connectors\ERP\Interfaces;

interface IRead
{
    public static function all(): array;
    public static function get(String $id): object;
    public static function filter(array $filters): array;
}
