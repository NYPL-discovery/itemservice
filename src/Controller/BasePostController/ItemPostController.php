<?php
namespace NYPL\Services\Controller\BasePostController;

use NYPL\Services\Controller\BasePostController;
use NYPL\Services\Model\DataModel\BaseItem\Item;
use NYPL\Services\Model\DataModel\BasePostRequest\ItemPostRequest;
use NYPL\Starter\APIException;
use NYPL\Starter\Config;

final class ItemPostController extends BasePostController
{
    protected function getBaseRecord()
    {
        return new Item();
    }

    protected function getPostRequest()
    {
        return new ItemPostRequest();
    }

    /**
     * @SWG\Post(
     *     path="/v0.1/item-post-requests",
     *     summary="Create a new Item Post Request",
     *     description="Request records be re-posted to the ItemBulk stream. You can specify lastId or ids. If using lastId, you can post up to 500 records starting from the record after lastId.",
     *     tags={"items"},
     *     operationId="createItemPostRequest",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="ItemPostRequest",
     *         in="body",
     *         description="",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/ItemPostRequest")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/PostRequestSuccess")
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthorized"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Not found",
     *         @SWG\Schema(ref="#/definitions/ErrorResponse")
     *     ),
     *     @SWG\Response(
     *         response="500",
     *         description="Generic server error",
     *         @SWG\Schema(ref="#/definitions/ErrorResponse")
     *     ),
     *     security={
     *         {
     *             "api_auth": {"openid read:item"}
     *         }
     *     }
     * )
     * @throws APIException|\RuntimeException
     */
    public function createItemPostRequest()
    {
        return $this->createPostRequest(Config::get('ITEM_BULK_STREAM_NAME'));
    }
}
