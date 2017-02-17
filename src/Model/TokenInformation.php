<?php
namespace NYPL\Services\Model;

use NYPL\Services\Model\DataModel\BasePatron\Patron;
use NYPL\Starter\Model;

/**
 * @SWG\Definition(title="TokenInformation", type="object")
 */
class TokenInformation extends Model
{
    /**
     * @SWG\Property
     * @var DecodedToken
     */
    public $decodedToken;

    /**
     * @SWG\Property
     * @var Patron
     */
    public $patron;

    /**
     * @return DecodedToken
     */
    public function getDecodedToken()
    {
        return $this->decodedToken;
    }

    /**
     * @param DecodedToken $decodedToken
     */
    public function setDecodedToken($decodedToken)
    {
        $this->decodedToken = $decodedToken;
    }

    /**
     * @return Patron
     */
    public function getPatron()
    {
        return $this->patron;
    }

    /**
     * @param Patron $patron
     */
    public function setPatron($patron)
    {
        $this->patron = $patron;
    }
}
