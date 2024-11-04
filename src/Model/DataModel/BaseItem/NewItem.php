<?php
namespace NYPL\Services\Model\DataModel\BaseItem;

use NYPL\Services\Model\DataModel\BaseItem;

/**
 * @OA\Schema(type="object")
 */
class NewItem extends BaseItem
{
    /**
     * @OA\Property(example="sierra-nypl")
     * @var string
     */
    public $nyplSource;

    /**
     * @OA\Property()
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
