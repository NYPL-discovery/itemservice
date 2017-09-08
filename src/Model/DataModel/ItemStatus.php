<?php
namespace NYPL\Services\Model\DataModel;

use NYPL\Starter\Model;
use NYPL\Starter\Model\ModelTrait\TranslateTrait;
use NYPL\Starter\Model\LocalDateTime;

/**
 * @SWG\Definition(type="object", required={"code"})
 */
class ItemStatus extends Model
{
    use TranslateTrait;

    /**
     * @SWG\Property(example="-")
     * @var string
     */
    public $code;

    /**
     * @SWG\Property(example="AVAILABLE")
     * @var string
     */
    public $display;

    /**
     * @SWG\Property(example="2008-12-24T03:16:00Z", type="string")
     * @var Model\LocalDateTime
     */
    public $duedate;

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * @param string $display
     */
    public function setDisplay($display)
    {
        $this->display = $display;
    }

    /**
     * @return LocalDateTime
     */
    public function getDuedate()
    {
        return $this->duedate;
    }

    /**
     * @param LocalDateTime $duedate
     */
    public function setDuedate($duedate)
    {
        $this->duedate = $duedate;
    }

    /**
     * @param array|string $data
     *
     * @return LocalDateTime
     */
    public function translateDueDate($data)
    {
        return new LocalDateTime(LocalDateTime::FORMAT_DATE_TIME_RFC, $data);
    }
}
