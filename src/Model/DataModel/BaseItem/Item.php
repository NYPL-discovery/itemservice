<?php
namespace NYPL\Services\Model\DataModel\BaseItem;

use NYPL\Services\Model\DataModel\BaseItem;
use NYPL\Starter\Model\ModelInterface\DeleteInterface;
use NYPL\Starter\Model\ModelInterface\MessageInterface;
use NYPL\Starter\Model\ModelInterface\ReadInterface;
use NYPL\Starter\Model\ModelTrait\DBCreateTrait;
use NYPL\Starter\Model\ModelTrait\DBDeleteTrait;
use NYPL\Starter\Model\ModelTrait\DBReadTrait;
use NYPL\Starter\Model\ModelTrait\DBUpdateTrait;

/**
 * @SWG\Definition(title="Item", type="object", required={"id"})
 */
class Item extends BaseItem implements MessageInterface, ReadInterface, DeleteInterface
{
    use DBCreateTrait, DBReadTrait, DBDeleteTrait, DBUpdateTrait;

    /**
     * @SWG\Property(example="sierra-nypl")
     * @var string
     */
    public $nyplSource;

    /**
     * @SWG\Property()
     * @var string[]
     */
    public $bibIds;

    public function getSchema()
    {
        return json_decode(
            file_get_contents(__DIR__ . '/../../../../schemas/Item.json'),
            true
        );
    }

    public function getIdFields()
    {
        return ["nyplSource", "id"];
    }

    public function getSequenceId()
    {
        return "";
    }

    /**
     * @return array
     */
    public function getBibIds()
    {
        return $this->bibIds;
    }

    /**
     * @param array|string $bibIds
     */
    public function setBibIds($bibIds)
    {
        if (is_string($bibIds)) {
            $bibIds = json_decode($bibIds, true);
        }

        $this->bibIds = $bibIds;
    }
}
