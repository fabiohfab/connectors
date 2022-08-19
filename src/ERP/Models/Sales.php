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
        $this->project = $sales["project"];
        $this->documentId = $sales["documentId"];
        $this->document = $sales["document"];
        $this->documentFiscalSpace = $sales["documentFiscalSpace"];
        $this->client = $sales["client"];
        $this->clientName = $sales["clientName"];
        $this->documentDate = $sales["documentDate"];
        $this->documentDueDate = $sales["documentDueDate"];
        $this->rowId = $sales["rowId"];
        $this->rowNumber = $sales["rowNumber"];
        $this->rowWeMoldId = $sales["rowWeMoldId"];
        $this->rowDescription = $sales["rowDescription"];
        $this->rowArticle = $sales["rowArticle"];
        $this->rowArticleDescription = $sales["rowArticleDescription"];
        $this->rowQuantity = $sales["rowQuantity"];
        $this->rowUnitPrice = $sales["rowUnitPrice"];
        $this->rowNetPrice = $sales["rowNetPrice"];
    }

    public function project()
    {
        return $this->project;
    }

    public function documentId()
    {
        return $this->documentId;
    }

    public function document()
    {
        return $this->document;
    }

    public function documentFiscalSpace()
    {
        return $this->documentFiscalSpace;
    }

    public function client()
    {
        return $this->client;
    }

    public function clientName()
    {
        return $this->clientName;
    }

    public function documentDate()
    {
        return $this->documentDate;
    }

    public function documentDueDate()
    {
        return $this->documentDueDate;
    }

    public function rowId()
    {
        return $this->rowId;
    }

    public function rowNumber()
    {
        return $this->rowNumber;
    }

    public function rowWeMoldId()
    {
        return $this->rowWeMoldId;
    }

    public function rowDescription()
    {
        return $this->rowDescription;
    }

    public function rowArticle()
    {
        return $this->rowArticle;
    }

    public function rowArticleDescription()
    {
        return $this->rowArticleDescription;
    }

    public function rowQuantity()
    {
        return $this->rowQuantity;
    }

    public function rowUnitPrice()
    {
        return $this->rowUnitPrice;
    }

    public function rowNetPrice()
    {
        return $this->rowNetPrice;
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

    public function __toString()
    {
        return $this->rowId();
    }
}
