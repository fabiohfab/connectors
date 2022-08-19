<?php

namespace Sinmetro\Connectors\ERP\Repositories\Anvera;

use Sinmetro\Connectors\ERP\Interfaces\IDelete;
use Sinmetro\Connectors\ERP\Interfaces\IRead;
use Sinmetro\Connectors\ERP\Interfaces\IWrite;
use Sinmetro\Connectors\ERP\Models\Budget;
use Sinmetro\Connectors\Requests\AnveraRequestConnector;

class BudgetRepository implements IRead, IWrite, IDelete
{
    protected const BASE_URL = "orcamentos";

    public static function all(): array
    {
        return array();
    }

    public static function get(String $id): Budget
    {
        return new Budget(array());
    }

    public static function filter(array $filters): array
    {
        $query = "";
        foreach ($filters as $key => $value) {
            $query .= "/{$key}/{$value}";
        }

        $budgets = array();
        $response = AnveraRequestConnector::getRequest(self::BASE_URL.$query);

        foreach ($response as $budget) {
            array_push($budgets, self::parseBudget($budget));
        }

        return $budgets;
    }

    public static function store(Budget $budget): Budget
    {
        $response = AnveraRequestConnector::postRequest(self::BASE_URL, ["body" => json_encode(self::transformBudgetModel($budget))]);

        return self::parseBudget($response);
    }

    public static function update(array $budgets): array
    {
        $updatedBudgets = array();

        foreach ($budgets as $budget) {
            $response = AnveraRequestConnector::updateRequest(self::BASE_URL."/editar", [
                "body" => json_encode(self::transformBudgetModel($budget))
            ], true);
            array_push($updatedBudgets, self::parseBudget($response));
        }

        return $updatedBudgets;
    }

    public static function delete(String $id): void
    {
        AnveraRequestConnector::deleteRequest(self::BASE_URL."/apagar?id={$id}");
    }


    //Budgets
    public static function cancelByProject(String $project): array
    {
        $budgets = array();
        $response = AnveraRequestConnector::updateRequest(self::BASE_URL."/anular/projetos/{$project}", []);

        foreach ($response as $budget) {
            array_push($budgets, self::parseBudget($budget));
        }

        return $budgets;
    }

    protected static function transformBudgetModel(Budget $budget)
    {
        return [
            "cliente" => $budget->client(),
            "projeto" => $budget->project(),
            "tipoProjeto" => $budget->projectType(),
            "linhas" => array_map(function ($row) {
                return [
                    "id" => $row->id(),
                    "valor" => $row->value(),
                    "quatidade" =>  $row->quantity(),
                    "descricao" => $row->description(),
                ];
            }, $budget->rows()),
        ];
    }

    protected static function parseBudget(array $budget)
    {
        return new Budget([
            "client" => array_key_exists("cliente", $budget) ? $budget["cliente"] : null,
            "project" => array_key_exists("projeto", $budget) ? $budget["projeto"] : null,
            "projectType" => array_key_exists("tipoProjeto", $budget) ? $budget["tipoProjeto"] : null,
            "rows" => array_key_exists("linhas", $budget) ? array_map(function ($row) {
                return [
                    "id" => array_key_exists("id", $row) ? $row["id"] : null,
                    "value" => array_key_exists("valor", $row) ? $row["valor"] : null,
                    "quantity" => array_key_exists("quatidade", $row) ? $row["quatidade"] : null,
                    "description" => array_key_exists("descricao", $row) ? $row["descricao"] : null,
                ];
            }, $budget["linhas"]) : null,
        ]);
    }
}
