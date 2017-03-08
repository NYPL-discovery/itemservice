<?php
namespace NYPL\Services\Model\Response\BulkResponse;

use NYPL\Services\Model\DataModel\BaseItem\Item;
use NYPL\Starter\Model\Response\BulkResponse;

/**
 * @SWG\Definition(title="BibsResponse", type="object")
 */
class BulkItemsResponse extends BulkResponse
{
    /**
     * @SWG\Property
     * @var Item[]
     */
    public $data;
}
