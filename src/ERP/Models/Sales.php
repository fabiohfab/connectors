<?php

namespace Sinmetro\Connectors\ERP\Models;

class Sales
{
    protected $project;
    protected $documentId;
    protected $document;
    protected $documentFiscalSpace;
    protected $client;
    protected $clientName;
    protected $documentDate;
    protected $documentDueDate;
    protected $rowId;
    protected $rowNumber;
    protected $rowWeMoldId;
    protected $rowDescription;
    protected $rowArticle;
    protected $rowArticleDescription;
    protected $rowQuantity;
    protected $rowUnitPrice;
    protected $rowNetPrice;

    public function __construct(array $sales = null)
    {
        foreach ($sales as $key => $value) {
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
            "project" => $this->project(),
            "documentId" => $this->documentId(),
            "document" => $this->document(),
            "documentFiscalSpace" => $this->documentFiscalSpace(),
            "client" => $this->client(),
            "clientName" => $this->clientName(),
            "documentDate" => $this->documentDate(),
            "documentDueDate" => $this->documentDueDate(),
            "rowId" => $this->rowId(),
            "rowNumber" => $this->rowNumber(),
            "rowWeMoldId" => $this->rowWeMoldId(),
            "rowDescription" => $this->rowDescription(),
            "rowArticle" => $this->rowArticle(),
            "rowArticleDescription" => $this->rowArticleDescription(),
            "rowQuantity" => $this->rowQuantity(),
            "rowUnitPrice" => $this->rowUnitPrice(),
            "rowNetPrice" => $this->rowNetPrice(),
        ];
    }
}
