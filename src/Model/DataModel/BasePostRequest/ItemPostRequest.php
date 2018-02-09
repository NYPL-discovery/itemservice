<?php
namespace NYPL\Services\Model\DataModel\BasePostRequest;

use NYPL\Services\Model\DataModel\BasePostRequest;
use NYPL\Starter\Config;
use NYPL\Starter\Model\ModelInterface\MessageInterface;
use NYPL\Starter\Model\ModelInterface\ReadInterface;
use NYPL\Starter\Model\ModelTrait\DBReadTrait;
use NYPL\Starter\SchemaClient;

/**
 * @SWG\Definition(title="ItemPostRequest", type="object", required={"id"})
 */
class ItemPostRequest extends BasePostRequest implements MessageInterface, ReadInterface
{
    use DBReadTrait;

    /**
     * @return string
     * @throws \NYPL\Starter\APIException
     */
    public function getStreamName()
    {
        return Config::get('ITEM_STREAM_NAME');
    }

    public function getSchema()
    {
        return SchemaClient::getSchema('Item')->getSchema();
    }

    public function getIdFields()
    {
        return ['nyplSource', 'id'];
    }
}
