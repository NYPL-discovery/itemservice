<?php
namespace NYPL\Services\Model\Response\SuccessResponse;

use NYPL\Services\Model\DataModel\BaseItem\Item;
use NYPL\Starter\Model\Response\SuccessResponse;

/**
 * @OA\Schema(title="ItemResponse", type="object")
 */
class ItemResponse extends SuccessResponse
{
    /**
     * @OA\Property
     * @var Item
     */
    public $data;
}
