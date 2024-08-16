<?php
namespace NYPL\Services\Model\Response\SuccessResponse;

use NYPL\Services\Model\DataModel\BaseItem\Item;
use NYPL\Starter\Model\Response\SuccessResponse;

/**
 * @OA\Definition(title="ItemsResponse", type="object")
 */
class ItemsResponse extends SuccessResponse
{
    /**
     * @OA\Property
     * @var Item[]
     */
    public $data;
}
