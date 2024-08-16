<?php
namespace NYPL\Services\Controller\BasePostController;

use NYPL\Services\Controller\BasePostController;
use NYPL\Services\Model\DataModel\BaseItem\Item;
use NYPL\Services\Model\DataModel\BasePostRequest\ItemPostRequest;
use NYPL\Starter\APIException;
use NYPL\Starter\Config;

/**
 * @OA\Tag(
 *     name="user",
 *     description="User related operations"
 * )
 * @OA\Info(
 *     version="1.0",
 *     title="Example API",
 *     description="Example info",
 *     @OA\Contact(name="Swagger API Team")
 * )
 * @OA\Server(
 *     url="https://example.localhost",
 *     description="API server"
 * )
 */
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
     * @OA\Post(
     *     path="/v0.1/item-post-requests",
     *     summary="Create a new Item Post Request",
     *     description="Request records be re-posted to the BibBulk stream. You can specify `lastId` and/or `lastUpdatedDate` or `ids`.
    If using `lastId` or `lastUpdatedDate`, you can post up to 500 records starting from the record after `lastId` and/or `lastUpdatedDate`.",
     *     tags={"items"},
     *     operationId="createItemPostRequest",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @OA\Parameter(
     *         name="ItemPostRequest",
     *         in="body",
     *         description="",
     *         required=true,
     *         @OA\Schema(ref="#/definitions/ItemPostRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\Schema(ref="#/definitions/PostRequestSuccess")
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not found",
     *         @OA\Schema(ref="#/definitions/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Generic server error",
     *         @OA\Schema(ref="#/definitions/ErrorResponse")
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
