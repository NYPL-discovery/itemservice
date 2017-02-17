<?php
namespace NYPL\Services\Model\DataModel\BaseItem;

use NYPL\Services\Model\DataModel\BaseItem;
use NYPL\Starter\Model\ModelInterface\DeleteInterface;
use NYPL\Starter\Model\ModelInterface\MessageInterface;
use NYPL\Starter\Model\ModelInterface\ReadInterface;
use NYPL\Starter\Model\ModelTrait\DBCreateTrait;
use NYPL\Starter\Model\ModelTrait\DBDeleteTrait;
use NYPL\Starter\Model\ModelTrait\DBReadTrait;
use NYPL\Starter\Model\ModelTrait\DBUpdateTrait;

/**
 * @SWG\Definition(title="Item", type="object", required={"id"})
 */
class Item extends BaseItem implements MessageInterface, ReadInterface, DeleteInterface
{
    use DBCreateTrait, DBReadTrait, DBDeleteTrait, DBUpdateTrait;

    /**
     * @SWG\Property(example="nypl-sierra")
     * @var string
     */
    public $nyplSource;

    /**
     * @SWG\Property()
     * @var string[]
     */
    public $bibIds;

    public function getSchema()
    {
        return
            [
                "name" => "Item",
                "type" => "record",
                "fields" => [
                    ["name" => "id", "type" => "string"],
                    ["name" => "nyplSource", "type" => ["string", "null"]],
                    ["name" => "nyplType", "type" => ["string", "null"]],
                    ["name" => "updatedDate", "type" => ["string", "null"]],
                    ["name" => "createdDate", "type" => ["string", "null"]],
                    ["name" => "deletedDate", "type" => ["string", "null"]],
                    ["name" => "deleted", "type" => ["boolean", "null"]],
                    ["name" => "bibIds" , "type" => [
                        "null",
                        ["type" => "array", "items" => "string"],
                    ]],
                    ["name" => "location" , "type" => [
                        "null",
                        ["name" => "location", "type" => "record", "fields" => [
                            ["name" => "code", "type" => ["string", "null"]],
                            ["name" => "name", "type" => ["string", "null"]],
                        ]],
                    ]],
                    ["name" => "status" , "type" => [
                        "null",
                        ["name" => "status", "type" => "record", "fields" => [
                            ["name" => "code", "type" => ["string", "null"]],
                            ["name" => "display", "type" => ["string", "null"]],
                            ["name" => "dueDate", "type" => ["string", "null"]],
                        ]],
                    ]],
                    ["name" => "barcode", "type" => ["string", "null"]],
                    ["name" => "callNumber", "type" => ["string", "null"]],
                    ["name" => "itemType", "type" => ["string", "null"]],
                    ["name" => "fixedFields" , "type" => [
                        "null",
                        ["type" => "array", "items" => [
                            ["name" => "fixedField", "type" => "record", "fields" => [
                                ["name" => "label", "type" => ["string", "null"]],
                                ["name" => "value", "type" => ["string", "int", "boolean", "null"]],
                                ["name" => "display", "type" => ["string", "int", "boolean", "null"]],
                            ]]
                        ]],
                    ]],
                    ["name" => "varFields" , "type" => [
                        "null",
                        ["type" => "array", "items" => [
                            ["name" => "varField", "type" => "record", "fields" => [
                                ["name" => "fieldTag", "type" => ["string", "null"]],
                                ["name" => "marcTag", "type" => ["string", "null"]],
                                ["name" => "ind1", "type" => ["string", "null"]],
                                ["name" => "ind2", "type" => ["string", "null"]],
                                ["name" => "content", "type" => ["string", "null"]],
                                ["name" => "subFields" , "type" => [
                                    "null",
                                    ["type" => "array", "items" => [
                                        ["name" => "subField", "type" => "record", "fields" => [
                                            ["name" => "tag", "type" => ["string", "null"]],
                                            ["name" => "content", "type" => ["string", "null"]],
                                        ]]
                                    ]],
                                ]],
                            ]]
                        ]],
                    ]],
                ]
            ];
    }

    public function getIdFields()
    {
        return ["nyplSource", "id"];
    }

    public function getSequenceId()
    {
        return "";
    }

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
