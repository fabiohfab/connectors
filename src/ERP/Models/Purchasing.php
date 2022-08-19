<?php

namespace Sinmetro\Connectors\ERP\Models;

class Purchasing
{
    protected $project;
    protected $documentId;
    protected $document;
    protected $documentFiscalSpace;
    protected $supplier;
    protected $supplierName;
    protected $documentDate;
    protected $documentDueDate;
    protected $rowId;
    protected $rowNumber;
    protected $rowDescription;
    protected $rowArticle;
    protected $rowArticleDescription;
    protected $rowQuantity;
    protected $rowUnitPrice;
    protected $rowNetPrice;

    public function __construct(array $purchasing = null)
    {
        $this->project =  $purchasing["project"];
        $this->documentId =  $purchasing["documentId"];
        $this->document =  $purchasing["document"];
        $this->documentFiscalSpace =  $purchasing["documentFiscalSpace"];
        $this->supplier =  $purchasing["supplier"];
        $this->supplierName =  $purchasing["supplierName"];
        $this->documentDate =  $purchasing["documentDate"];
        $this->documentDueDate =  $purchasing["documentDueDate"];
        $this->rowId =  $purchasing["rowId"];
        $this->rowNumber =  $purchasing["rowNumber"];
        $this->rowDescription =  $purchasing["rowDescription"];
        $this->rowArticle =  $purchasing["rowArticle"];
        $this->rowArticleDescription =  $purchasing["rowArticleDescription"];
        $this->rowQuantity =  $purchasing["rowQuantity"];
        $this->rowUnitPrice =  $purchasing["rowUnitPrice"];
        $this->rowNetPrice =  $purchasing["rowNetPrice"];
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

    public function supplier()
    {
        return $this->supplier;
    }

    public function supplierName()
    {
        return $this->supplierName;
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
            "supplier" => $this->supplier(),
            "supplierName" => $this->supplierName(),
            "documentDate" => $this->documentDate(),
            "documentDueDate" => $this->documentDueDate(),
            "rowId" => $this->rowId(),
            "rowNumber" => $this->rowNumber(),
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
