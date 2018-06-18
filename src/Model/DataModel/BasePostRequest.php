<?php
namespace NYPL\Services\Model\DataModel;

use NYPL\Services\Model\DataModel;
use NYPL\Starter\APIException;
use NYPL\Starter\Model\LocalDateTime;
use NYPL\Starter\Model\ModelTrait\TranslateTrait;

abstract class BasePostRequest extends DataModel
{
    public const MAX_LIMIT = 500;

    use TranslateTrait;

    /**
     * @SWG\Property(example="sierra-nypl")
     * @var string
     */
    public $nyplSource = '';

    /**
     * @SWG\Property(example="26823541")
     * @var string|null
     */
    public $lastId;

    /**
     * @SWG\Property(example="2016-01-07T02:32:51Z", type="string")
     * @var LocalDateTime
     */
    public $lastUpdatedDate;

    /**
     * @SWG\Property(example=100)
     * @var int
     */
    public $limit;

    /**
     * @SWG\Property
     * @var string[]
     */
    public $ids;

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
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     *
     * @throws APIException
     */
    public function setLimit($limit = 0)
    {
        $limit = (int) $limit;

        if ($limit > self::MAX_LIMIT) {
            throw new APIException(
                'Limit specified (' . $limit . ') exceeds maximum limit (' . self::MAX_LIMIT . ')'
            );
        }

        $this->limit = $limit;
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
     * @param $data
     *
     * @return array
     */
    public function translateIds($data)
    {
        if (is_string($data)) {
            $data = json_decode($data);
        }

        return $data;
    }

    /**
     * @return LocalDateTime
     */
    public function getLastUpdatedDate()
    {
        return $this->lastUpdatedDate;
    }

    /**
     * @param LocalDateTime $lastUpdatedDate
     */
    public function setLastUpdatedDate(LocalDateTime $lastUpdatedDate)
    {
        $this->lastUpdatedDate = $lastUpdatedDate;
    }

    /**
     * @param string $updatedDate
     *
     * @return LocalDateTime
     */
    public function translateLastUpdatedDate($updatedDate = '')
    {
        return new LocalDateTime(LocalDateTime::FORMAT_DATE_TIME_RFC, $updatedDate);
    }
}
