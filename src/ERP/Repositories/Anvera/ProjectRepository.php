<?php

namespace Sinmetro\Connectors\ERP\Repositories\Anvera;

use Sinmetro\Connectors\ERP\Interfaces\IRead;
use Sinmetro\Connectors\ERP\Interfaces\IWrite;
use Sinmetro\Connectors\ERP\Models\Project;
use Sinmetro\Connectors\Requests\AnveraRequestConnector;

class ProjectRepository implements IRead, IWrite
{
    protected const BASE_URL = "projetos";

    public static function all(): array
    {
        $projects = array();
        $response = AnveraRequestConnector::getRequest(self::BASE_URL);

        foreach ($response as $project) {
            array_push($projects, self::parseProject($project));
        }

        return $projects;
    }

    public static function get(String $id): Project
    {
        $response = AnveraRequestConnector::getRequest(self::BASE_URL."/{$id}");

        return self::parseProject($response);
    }

    public static function filter(array $filters, String $docType = null): array
    {
        $query = "";
        foreach ($filters as $key => $value) {
            $query .= "/{$key}/{$value}";
        }

        $orders = array();
        $response = AnveraRequestConnector::getRequest(self::BASE_URL.$query);

        foreach ($response as $order) {
            array_push($orders, self::parseProject($order));
        }

        return $orders;
    }

    public static function store(Project $project): Project
    {
        $response = AnveraRequestConnector::postRequest(self::BASE_URL, ["body" => json_encode(self::transformProjectModel($project))]);

        return self::parseProject($response);
    }

    public static function update(array $projects): array
    {
        $updatedProjects = array();

        foreach ($projects as $project) {
            $response = AnveraRequestConnector::updateRequest(self::BASE_URL."/editar", [
                "body" => json_encode(self::transformProjectModel($project))
            ], true);
            array_push($updatedProjects, self::parseProject($response));
        }

        return $updatedProjects;
    }

    protected static function transformProjectModel(Project $project)
    {
    }

    protected static function parseProject(array $project)
    {
    }
}
