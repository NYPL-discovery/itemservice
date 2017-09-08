<?php
namespace NYPL\Services\Controller;

use NYPL\Services\Model\Response\SuccessResponse\ItemsResponse;
use NYPL\Starter\Controller;
use NYPL\Starter\Filter;
use NYPL\Services\Model\DataModel\BaseItem\Item;
use NYPL\Services\Model\Response\SuccessResponse\ItemResponse;
use NYPL\Starter\ModelSet;

final class BibController extends Controller
{
    /**
     * @SWG\Get(
     *     path="/v0.1/bibs/{nyplSource}/{id}/items",
     *     summary="Get items for a Bib",
     *     tags={"bibs"},
     *     operationId="getBibItems",
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
     *             "api_auth": {"openid offline_access api"}
     *         }
     *     }
     * )
     */
    public function getBibItems($nyplSource = '', $id = '')
    {
        $items = new ModelSet(new Item());

        $items->addFilter(new Filter('nyplSource', $nyplSource));
        $items->addFilter(new Filter('bibIds', $id, true));

        return $this->getDefaultReadResponse(
            $items,
            new ItemsResponse()
        );
    }

    /**
     * @SWG\Post(
     *     path="/v0.1/bibs/{nyplSource}/{id}/items",
     *     summary="Create a new Item for a Bib",
     *     tags={"bibs"},
     *     operationId="createBibItem",
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
     *     @SWG\Parameter(
     *         name="NewBibItem",
     *         in="body",
     *         description="",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/NewBibItem"),
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
     *             "api_auth": {"openid offline_access api"}
     *         }
     *     }
     * )
     */
    public function createBibItem($nyplSource = '', $id = '')
    {
        $data = $this->getRequest()->getParsedBody();

        $data['nyplSource'] = $nyplSource;
        $data['bibIds'] = [$id];

        $item = new Item($data);
        $item->create(true);

        return $this->getResponse()->withJson(
            new ItemResponse($item)
        );
    }
}
