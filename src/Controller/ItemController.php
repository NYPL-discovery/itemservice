<?php
namespace NYPL\Services\Controller;

use NYPL\Starter\Controller;
use NYPL\Starter\Filter;
use NYPL\Services\Model\DataModel\BaseItem\Item;
use NYPL\Services\Model\Response\SuccessResponse\ItemResponse;
use NYPL\Services\Model\Response\SuccessResponse\ItemsResponse;
use NYPL\Starter\ModelSet;

final class ItemController extends Controller
{
    /**
     * @SWG\Post(
     *     path="/v0.1/items",
     *     summary="Create a new Item",
     *     tags={"items"},
     *     operationId="createItem",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="NewItem",
     *         in="body",
     *         description="",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/NewItem"),
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/ItemResponse")
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
     *             "api_auth": {"openid api"}
     *         }
     *     }
     * )
     */
    public function createItem($nyplSource = "", $id = "")
    {
        $data = $this->getRequest()->getParsedBody();

        if ($nyplSource && $id) {
            $data['nyplSource'] = $nyplSource;
            $data['bibIds'] = [$id];
        }

        $item = new Item($data);
        $item->create(true);

        return $this->getResponse()->withJson(
            new ItemResponse($item)
        );
    }

    /**
     * @SWG\Get(
     *     path="/v0.1/items",
     *     summary="Get a list of Items",
     *     tags={"items"},
     *     operationId="getItems",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         required=false,
     *         type="string",
     *         description="Separate multiple IDs with a comma"
     *     ),
     *     @SWG\Parameter(
     *         name="offset",
     *         in="query",
     *         required=false,
     *         type="integer"
     *     ),
     *     @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         required=false,
     *         type="integer"
     *     ),
     *     @SWG\Parameter(
     *         name="barcode",
     *         in="query",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="nyplSource",
     *         in="query",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/ItemsResponse")
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
     *             "api_auth": {"openid api"}
     *         }
     *     }
     * )
     */
    public function getItems($nyplSource = '', $id = '')
    {
        $items = new ModelSet(new Item());

        if ($nyplSource && $id) {
            $items->addFilter(new Filter('nyplSource', $nyplSource));
            $items->addFilter(new Filter('bibIds', $id, true));
        }

        return $this->getDefaultReadResponse(
            $items,
            new ItemsResponse()
        );
    }



    /**
     * @SWG\Get(
     *     path="/v0.1/items/{nyplSource}/{id}",
     *     summary="Get an Item",
     *     tags={"items"},
     *     operationId="getItem",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         in="path",
     *         name="nyplSource",
     *         required=true,
     *         type="string",
     *         format="string"
     *     ),
     *     @SWG\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         type="string",
     *         format="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/ItemResponse")
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
     *             "api_auth": {"openid api"}
     *         }
     *     }
     * )
     */
    public function getItem($nyplSource = '', $id = '')
    {
        $item = new Item();

        $item->addFilter(new Filter('id', $id));
        $item->addFilter(new Filter('nyplSource', $nyplSource));

        return $this->getDefaultReadResponse(
            $item,
            new ItemResponse()
        );
    }
}
