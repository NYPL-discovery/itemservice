<?php
namespace NYPL\Services\Model\Response\SuccessResponse;

use NYPL\Services\Model\DataModel\BaseItem\Item;
use NYPL\Starter\Model\Response\SuccessResponse;

/**
 * @SWG\Definition(title="ItemResponse", type="object")
 */
class ItemResponse extends SuccessResponse
{
    /**
     * @SWG\Property
     * @var Item
     */
    public $data;
}
