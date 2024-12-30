<?php
namespace NYPL\Services\Controller;

use NYPL\Services\Model\DataModel\BasePostRequest;
use NYPL\Services\Model\Response\PostRequestSuccess;
use NYPL\Starter\APIException;
use NYPL\Starter\BulkModels;
use NYPL\Starter\Controller;
use NYPL\Starter\Filter;
use NYPL\Starter\Model;
use NYPL\Starter\ModelSet;
use NYPL\Starter\Model\LocalDateTime;
use NYPL\Starter\OrderBy;
use Psr\Http\Message\MessageInterface;

abstract class BasePostController extends Controller
{
    abstract protected function getBaseRecord();

    /**
     * @return BasePostRequest
     */
    abstract protected function getPostRequest();

    /**
     * @param string $lastId
     * @param string $nyplSource
     * @param int $limit
     * @param array $ids
     * @param LocalDateTime|null $lastDateUpdated
     *
     * @return ModelSet|void
     * @throws APIException
     */
    protected function getRecords($lastId = '', $nyplSource = '', $limit = 0, $ids = [], LocalDateTime $lastDateUpdated = null)
    {
        $records = new ModelSet($this->getBaseRecord());

        if ($nyplSource) {
            $records->addFilter(new Filter\QueryFilter('nypl-source', $nyplSource));
        }

        if ($lastDateUpdated) {
            $records->addOrderBy(new OrderBy('updated_date'));
        }

        $records->addOrderBy(new OrderBy('id'));

        if ($lastId || $lastDateUpdated) {
            if ($lastDateUpdated) {
                $records->addFilter(
                    new Filter\QueryFilter('updated_date', $lastDateUpdated->getDateTime()->format('c'), false, '>')
                );
            }

            if ($lastId) {
                $records->addFilter(
                    new Filter\QueryFilter('id', $lastId, false, '>')
                );
            }

            $records->setLimit($limit);

            $records->read();

            return $records;
        }

        if ($ids) {
            $records->addFilter(
                new Filter\QueryFilter('id', $ids)
            );

            $records->read();

            return $records;
        }
    }

    /**
     * @param ModelSet $modelSet
     *
     * @return Model
     */
    protected function getLastRecord(ModelSet $modelSet)
    {
        return $modelSet->getData()[count($modelSet->getData()) - 1];
    }

    /**
     * @param ModelSet $modelSet
     *
     * @return string
     */
    protected function getLastId(ModelSet $modelSet)
    {
        return $this->getLastRecord($modelSet)->getId();
    }

    /**
     * @param ModelSet $modelSet
     *
     * @return LocalDateTime
     */
    protected function getLastUpdatedDate(ModelSet $modelSet)
    {
        return $this->getLastRecord($modelSet)->getUpdatedDate();
    }

    /**
     * @param string $streamName
     *
     * @return MessageInterface
     * @throws APIException|\RuntimeException
     */
    public function createPostRequest($streamName = '')
    {
        $postRequest = $this->getPostRequest();

        if (!$this->getRequest()->getParsedBody()) {
            throw new APIException('Invalid JSON provided in request body', null, 0, null, 400);
        }

        $postRequest->translate($this->getRequest()->getParsedBody());

        if (!$postRequest->getLastId() && !$postRequest->getIds() && !$postRequest->getLastUpdatedDate()) {
            throw new APIException('lastId, lastUpdatedDate, or ids were not specified', null, 0, null, 400);
        }

        if ($postRequest->getLastId() && !$postRequest->getLimit()) {
            throw new APIException('limit was not specified', null, 0, null, 400);
        }

        $records = $this->getRecords(
            $postRequest->getLastId(),
            $postRequest->getNyplSource(),
            $postRequest->getLimit(),
            $postRequest->getIds(),
            $postRequest->getLastUpdatedDate()
        );

        if ($postRequest->getLastId() || $postRequest->getLastUpdatedDate()) {
            $postRequest->setLastId($this->getLastId($records));
        }

        if ($postRequest->getLastUpdatedDate()) {
            $postRequest->setLastUpdatedDate($this->getLastUpdatedDate($records));
        }

        $bulkModels = new BulkModels();
        $bulkModels->setSuccessModels($records->getData());
        $bulkModels->publish($streamName);

        return $this->getJsonResponse(new PostRequestSuccess($postRequest, $bulkModels));
    }
}
