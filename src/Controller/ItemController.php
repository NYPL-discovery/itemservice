<?php
namespace NYPL\Services\Controller;

use NYPL\Services\Model\DataModel\FixedField;
use NYPL\Services\Model\DataModel\ItemStatus;
use NYPL\Services\Model\Response\BulkResponse\BulkItemsResponse;
use NYPL\Starter\APIException;
use NYPL\Starter\BulkModels;
use NYPL\Starter\Config;
use NYPL\Starter\Controller;
use NYPL\Starter\Filter;
use NYPL\Services\Model\DataModel\BaseItem\Item;
use NYPL\Services\Model\Response\SuccessResponse\ItemResponse;
use NYPL\Services\Model\Response\SuccessResponse\ItemsResponse;
use NYPL\Starter\ModelSet;
use Psr\Http\Message\MessageInterface;

final class ItemController extends Controller
{

    /**
     * @OA\Post(
     *     path="/v0.1/items",
     *     summary="Create new Items",
     *     tags={"items"},
     *     operationId="createItem",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @OA\Parameter(
     *         name="NewItem",
     *         in="body",
     *         description="",
     *         required=true,
     *         @OA\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/components/schemas/NewItem")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\Schema(ref="#/components/schemas/BulkItemsResponse")
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not found",
     *         @OA\Schema(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Generic server error",
     *         @OA\Schema(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     security={
     *         {
     *             "api_auth": {"openid write:item"}
     *         }
     *     }
     * )
     */
    public function createItem()
    {
        $bulkModels = new BulkModels();

        foreach ($this->getRequest()->getParsedBody() as $itemData) {
            if (!isset($itemData['nyplSource'])) {
                $itemData['nyplSource'] = 'sierra-nypl';
            }

            if (!isset($itemData['nyplType'])) {
                $itemData['nyplType'] = 'item';
            }

            $bulkModels->addModel(new Item($itemData));
        }

        $bulkModels->create(true);

        return $this->getJsonResponse(
            new BulkItemsResponse(
                $bulkModels->getSuccessModels(),
                $bulkModels->getBulkErrors()
            )
        );
    }

    /**
     * @OA\Get(
     *     path="/v0.1/items",
     *     summary="Get a list of Items",
     *     tags={"items"},
     *     operationId="getItems",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=false,
     *         type="string",
     *         description="Separate multiple IDs with a comma"
     *     ),
     *     @OA\Parameter(
     *         name="offset",
     *         in="query",
     *         required=false,
     *         type="integer"
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         required=false,
     *         type="integer"
     *     ),
     *     @OA\Parameter(
     *         name="barcode",
     *         in="query",
     *         required=false,
     *         type="string"
     *     ),
     *     @OA\Parameter(
     *         name="nyplSource",
     *         in="query",
     *         required=false,
     *         type="string"
     *     ),
     *     @OA\Parameter(
     *         name="bibId",
     *         in="query",
     *         required=false,
     *         type="string"
     *     ),
     *     @OA\Parameter(
     *         name="createdDate",
     *         in="query",
     *         required=false,
     *         type="string",
     *         description="Specific start date or date range (e.g. [2013-09-03T13:17:45Z,2013-09-03T13:37:45Z])"
     *     ),
     *     @OA\Parameter(
     *         name="updatedDate",
     *         in="query",
     *         required=false,
     *         type="string",
     *         description="Specific start date or date range (e.g. [2013-09-03T13:17:45Z,2013-09-03T13:37:45Z])"
     *     ),
     *     @OA\Parameter(
     *         name="deleted",
     *         in="query",
     *         required=false,
     *          type="boolean",
     *          @OA\Items(
     *              enum={"true", "false"},
     *              default=""
     *          ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\Schema(ref="#/components/schemas/ItemsResponse")
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not found",
     *         @OA\Schema(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Generic server error",
     *         @OA\Schema(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     security={
     *         {
     *             "api_auth": {"openid read:item"}
     *         }
     *     }
     * )
     */
    public function getItems()
    {
        if ($bidId = $this->getQueryParam('bibId')) {
            $items = new ModelSet(new Item());

            $items->addFilter(new Filter('bibIds', $bidId, true));

            if ($nyplSource = $this->getQueryParam('nyplSource')) {
                $items->addFilter(new Filter('nypl-source', $nyplSource));
            }

            return $this->getDefaultReadResponse(
                $items,
                new ItemsResponse()
            );
        }

        return $this->getDefaultReadResponse(
            new ModelSet(new Item()),
            new ItemsResponse(),
            null,
            ['barcode', 'nyplSource', 'id', 'updatedDate', 'createdDate', 'deleted']
        );
    }

    /**
     * @OA\Get(
     *     path="/v0.1/items/{nyplSource}/{id}",
     *     summary="Get an Item",
     *     tags={"items"},
     *     operationId="getItem",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @OA\Parameter(
     *         in="path",
     *         name="nyplSource",
     *         required=true,
     *         type="string",
     *         format="string"
     *     ),
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         type="string",
     *         format="string"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\Schema(ref="#/components/schemas/ItemResponse")
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not found",
     *         @OA\Schema(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Generic server error",
     *         @OA\Schema(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     security={
     *         {
     *             "api_auth": {"openid read:item"}
     *         }
     *     }
     * )
     */
    public function getItem($nyplSource = '', $id = '')
    {
        $item = new Item();

        $item->addFilter(new Filter('id', $id));
        $item->addFilter(new Filter('nyplSource', $nyplSource));

        $item->read();

        // Overwriting status for SCSB calls
        $identity = $this->getIdentityHeader()->getIdentity();
        if (isset($identity['aud']) && $identity['aud'] === 'htc_scsb') {
            $status = new ItemStatus();
            $status->setCode('t');
            $status->setDisplay('IN TRANSIT');
            $item->setStatus($status);

            $statusField = new FixedField();
            $statusField->setLabel('Status');
            $statusField->setValue('t');
            $statusField->setDisplay('IN TRANSIT');
            $item->addFixedField(88, $statusField);
        }

        return $this->getJsonResponse(new ItemResponse($item));
    }

    /**
     * @param string $nyplSource
     * @param string $id
     *
     * @throws APIException
     * @return MessageInterface
     */
    public function redirectToCatalog($nyplSource = '', $id = '')
    {
        $queryParams = http_build_query([
            'fromUrl' => $this->getQueryParam('fromUrl')
        ]);

        try {
            $item = new Item();

            $item->addFilter(new Filter('id', $id));
            $item->addFilter(new Filter('nyplSource', $nyplSource));

            $item->read();

            return $this->getResponse()
                ->withStatus(302)
                ->withHeader(
                    'Location',
                    Config::get('CATALOG_URL_PREFIX') . '/b' . $item->getBibIds()[0] . '-i' . $id . '?' . $queryParams
                );
        } catch (APIException $exception) {
            return $this->getResponse()
                ->withStatus(302)
                ->withHeader(
                    'Location',
                    Config::get('CATALOG_URL_PREFIX') . '/b1-i' . $id . '?' . $queryParams
                );
        }
    }
}
