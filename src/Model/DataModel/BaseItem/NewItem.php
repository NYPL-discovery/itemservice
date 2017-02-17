<?php
namespace NYPL\Services\Model\DataModel\BaseItem;

use NYPL\Services\Model\DataModel\BaseItem;

/**
 * @SWG\Definition(type="object")
 */
class NewItem extends BaseItem
{
    /**
     * @SWG\Property(example="nypl-sierra")
     * @var string
     */
    public $nyplSource;

    /**
     * @SWG\Property()
     * @var string[]
     */
    public $bibIds;

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
