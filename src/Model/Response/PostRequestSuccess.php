<?php
namespace NYPL\Services\Model\Response;

use NYPL\Services\Model\DataModel\BasePostRequest;

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
     * @param BasePostRequest $bibPostRequest
     */
    public function __construct(BasePostRequest $bibPostRequest = null)
    {
        if ($bibPostRequest) {
            $this->setLastId($bibPostRequest->getLastId());
            $this->setNyplSource($bibPostRequest->getNyplSource());
            $this->setLimit($bibPostRequest->getLimit());
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
}
