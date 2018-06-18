<?php
namespace NYPL\Services\Model\Response;

use NYPL\Services\Model\DataModel\BasePostRequest;
use NYPL\Starter\BulkModels;
use NYPL\Starter\Model\LocalDateTime;

/**
 * @SWG\Definition(title="PostRequestSuccess", type="object")
 */
class PostRequestSuccess
{
    /**
     * @SWG\Property(example="26823541")
     * @var string
     */
    public $lastId;

    /**
     * @SWG\Property(example="2016-01-07T02:32:51Z")
     * @var string
     */
    public $lastUpdatedDate;

    /**
     * @SWG\Property(example="sierra-nypl")
     * @var string
     */
    public $nyplSource;

    /**
     * @SWG\Property(example=100)
     * @var int
     */
    public $limit;

    /**
     * @SWG\Property
     * @var string[]
     */
    public $ids = [];

    /**
     * @SWG\Property(example=100)
     * @var int
     */
    public $count = 0;

    /**
     * @param BasePostRequest $bibPostRequest
     * @param BulkModels $bulkModels
     */
    public function __construct(BasePostRequest $bibPostRequest = null, BulkModels $bulkModels = null)
    {
        if ($bibPostRequest && $bulkModels) {
            $this->setLastId($bibPostRequest->getLastId());

            if ($bibPostRequest->getLastUpdatedDate()) {
                $this->setLastUpdatedDate($bibPostRequest->getLastUpdatedDate()->getDateTime()->format('c'));
            }

            $this->setNyplSource($bibPostRequest->getNyplSource());
            $this->setLimit($bibPostRequest->getLimit());
            $this->setIds($bibPostRequest->getIds());

            $this->setCount(count($bulkModels->getSuccessModels()));
        }
    }

    /**
     * @return string
     */
    public function getLastId()
    {
        return $this->lastId;
    }

    /**
     * @param string $lastId
     */
    public function setLastId($lastId = '')
    {
        $this->lastId = $lastId;
    }

    /**
     * @return string
     */
    public function getNyplSource()
    {
        return $this->nyplSource;
    }

    /**
     * @param string $nyplSource
     */
    public function setNyplSource($nyplSource = '')
    {
        $this->nyplSource = $nyplSource;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit = 0)
    {
        $this->limit = (int) $limit;
    }

    /**
     * @return string[]
     */
    public function getIds()
    {
        return $this->ids;
    }

    /**
     * @param string[] $ids
     */
    public function setIds($ids = [])
    {
        $this->ids = $ids;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount($count = 0)
    {
        $this->count = $count;
    }

    /**
     * @return string
     */
    public function getLastUpdatedDate(): string
    {
        return $this->lastUpdatedDate;
    }

    /**
     * @param string $lastUpdatedDate
     */
    public function setLastUpdatedDate(string $lastUpdatedDate): void
    {
        $this->lastUpdatedDate = $lastUpdatedDate;
    }
}
