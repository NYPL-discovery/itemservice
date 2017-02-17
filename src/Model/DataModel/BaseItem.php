<?php
namespace NYPL\Services\Model\DataModel;

use NYPL\Services\Model\DataModel;
use NYPL\Starter\Model\LocalDateTime;
use NYPL\Starter\Model\ModelTrait\TranslateTrait;

abstract class BaseItem extends DataModel
{
    use TranslateTrait;

    /**
     * @SWG\Property(example="17746307")
     * @var string
     */
    public $id;

    /**
     * @SWG\Property(example="item")
     * @var string
     */
    public $nyplType;

    /**
     * @SWG\Property(example="2016-01-07T02:32:51Z", type="string")
     * @var LocalDateTime
     */
    public $updatedDate;

    /**
     * @SWG\Property(example="2008-12-24T03:16:00Z", type="string")
     * @var LocalDateTime
     */
    public $createdDate;

    /**
     * @SWG\Property(example="2008-12-24", type="string")
     * @var LocalDateTime
     */
    public $deletedDate;

    /**
     * @SWG\Property(example=false)
     * @var bool
     */
    public $deleted;

    /**
     * @SWG\Property()
     * @var Location
     */
    public $location;

    /**
     * @SWG\Property()
     * @var ItemStatus
     */
    public $status;

    /**
     * @SWG\Property(example="33433001888415")
     * @var string
     */
    public $barcode;

    /**
     * @SWG\Property(example="|h*ONPA 84-446")
     * @var string
     */
    public $callNumber;

    /**
     * @SWG\Property(example="Book, paperback")
     * @var string
     */
    public $itemType;

    /**
     * @SWG\Property()
     * @var FixedField[]
     */
    public $fixedFields;

    /**
     * @SWG\Property()
     * @var VarField[]
     */
    public $varFields;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNyplSource()
    {
        return $this->nyplSource;
    }

    /**
     * @param string $nyplSource
     */
    public function setNyplSource($nyplSource)
    {
        $this->nyplSource = $nyplSource;
    }

    /**
     * @return LocalDateTime
     */
    public function getUpdatedDate()
    {
        return $this->updatedDate;
    }

    /**
     * @param LocalDateTime $updatedDate
     */
    public function setUpdatedDate(LocalDateTime $updatedDate)
    {
        $this->updatedDate = $updatedDate;
    }

    /**
     * @param string $updatedDate
     *
     * @return LocalDateTime
     */
    public function translateUpdatedDate($updatedDate = '')
    {
        return new LocalDateTime(LocalDateTime::FORMAT_DATE_TIME_RFC, $updatedDate);
    }

    /**
     * @return LocalDateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * @param LocalDateTime $createdDate
     */
    public function setCreatedDate(LocalDateTime $createdDate)
    {
        $this->createdDate = $createdDate;
    }

    /**
     * @param string $createdDate
     *
     * @return LocalDateTime
     */
    public function translateCreatedDate($createdDate = '')
    {
        return new LocalDateTime(LocalDateTime::FORMAT_DATE_TIME_RFC, $createdDate);
    }

    /**
     * @return boolean
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param boolean $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = boolval($deleted);
    }

    /**
     * @return LocalDateTime
     */
    public function getDeletedDate()
    {
        return $this->deletedDate;
    }

    /**
     * @param string $deletedDate
     *
     * @return LocalDateTime
     */
    public function translateDeletedDate($deletedDate = '')
    {
        return new LocalDateTime(LocalDateTime::FORMAT_DATE, $deletedDate);
    }

    /**
     * @param LocalDateTime $deletedDate
     */
    public function setDeletedDate($deletedDate)
    {
        $this->deletedDate = $deletedDate;
    }

    /**
     * @return FixedField[]
     */
    public function getFixedFields()
    {
        return $this->fixedFields;
    }

    /**
     * @param FixedField[] $fixedFields
     */
    public function setFixedFields($fixedFields)
    {
        $this->fixedFields = $fixedFields;
    }

    /**
     * @param array|string $data
     *
     * @return FixedField[]
     */
    public function translateFixedFields($data)
    {
        return $this->translateArray($data, new FixedField(), true);
    }

    /**
     * @return VarField[]
     */
    public function getVarFields()
    {
        return $this->varFields;
    }

    /**
     * @param VarField[] $varFields
     */
    public function setVarFields($varFields)
    {
        $this->varFields = $varFields;
    }

    /**
     * @param array|string $data
     *
     * @return VarField[]
     */
    public function translateVarFields($data)
    {
        return $this->translateArray($data, new VarField(), true);
    }

    /**
     * @return Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param Location $location
     */
    public function setLocation(Location $location)
    {
        $this->location = $location;
    }

    /**
     * @return ItemStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param ItemStatus $status
     */
    public function setStatus(ItemStatus $status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * @param string $barcode
     */
    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;
    }

    /**
     * @return string
     */
    public function getCallNumber()
    {
        return $this->callNumber;
    }

    /**
     * @param string $callNumber
     */
    public function setCallNumber($callNumber)
    {
        $this->callNumber = $callNumber;
    }

    /**
     * @param array|string $data
     *
     * @return Location
     */
    public function translateLocation($data)
    {
        return new Location($data, true);
    }

    /**
     * @param array|string $data
     *
     * @return ItemStatus
     */
    public function translateStatus($data)
    {
        return new ItemStatus($data, true);
    }

    /**
     * @return string
     */
    public function getItemType()
    {
        return $this->itemType;
    }

    /**
     * @param string $itemType
     */
    public function setItemType($itemType)
    {
        $this->itemType = $itemType;
    }

    /**
     * @return string
     */
    public function getNyplType()
    {
        return $this->nyplType;
    }

    /**
     * @param string $nyplType
     */
    public function setNyplType($nyplType)
    {
        $this->nyplType = $nyplType;
    }
}
