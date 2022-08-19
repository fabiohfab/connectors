<?php

namespace Sinmetro\Connectors\ERP;

class Connector
{
    public static function budget(String $erp)
    {
        $namespace = "\\Sinmetro\\Connectors\\ERP\\Stores\\BudgetStore";

        return new $namespace($erp);
    }

    public static function client(String $erp)
    {
        $namespace = "\\Sinmetro\\Connectors\\ERP\\Stores\\ClientStore";

        return new $namespace($erp);
    }

    public static function order(String $erp)
    {
        $namespace = "\\Sinmetro\\Connectors\\ERP\\Stores\\OrderStore";

        return new $namespace($erp);
    }

    public static function project(String $erp)
    {
        $namespace = "\\Sinmetro\\Connectors\\ERP\\Stores\\ProjectStore";

        return new $namespace($erp);
    }

    public static function PurchaseDocument(String $erp)
    {
        $namespace = "\\Sinmetro\\Connectors\\ERP\\Stores\\PurchaseDocumentStore";

        return new $namespace($erp);
    }

    public static function serie(String $erp)
    {
        $namespace = "\\Sinmetro\\Connectors\\ERP\\Stores\\SerieStore";

        return new $namespace($erp);
    }

    public static function supplier(String $erp)
    {
        $namespace = "\\Sinmetro\\Connectors\\ERP\\Stores\\SupplierStore";

        return new $namespace($erp);
    }

    public static function time(String $erp)
    {
        $namespace = "\\Sinmetro\\Connectors\\ERP\\Stores\\TimeStore";

        return new $namespace($erp);
    }

    public static function tranche(String $erp)
    {
        $namespace = "\\Sinmetro\\Connectors\\ERP\\Stores\\TrancheStore";

        return new $namespace($erp);
    }
}
