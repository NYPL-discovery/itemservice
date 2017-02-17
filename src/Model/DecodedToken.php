<?php
namespace NYPL\Services\Model;

use NYPL\Starter\Model;

/**
 * @SWG\Definition(title="DecodedToken", type="object")
 */
class DecodedToken extends Model
{
    use Model\ModelTrait\TranslateTrait;

    /**
     * @SWG\Property(example="https://www.nypl.org")
     * @var string
     */
    public $iss = '';

    /**
     * @SWG\Property(example="123123")
     * @var string
     */
    public $sub = '';

    /**
     * @SWG\Property(example="app_api")
     * @var string
     */
    public $aud = '';

    /**
     * @SWG\Property(example="1477706776")
     * @var string
     */
    public $iat = 0;

    /**
     * @SWG\Property(example="1477706776")
     * @var string
     */
    public $exp = 0;

    /**
     * @SWG\Property(example="1477706776")
     * @var string
     */
    public $auth_time = 0;

    /**
     * @SWG\Property(example="openid patron:read")
     * @var string
     */
    public $scope = '';

    /**
     * @return string
     */
    public function getIss()
    {
        return $this->iss;
    }

    /**
     * @param string $iss
     */
    public function setIss($iss)
    {
        $this->iss = $iss;
    }

    /**
     * @return string
     */
    public function getSub()
    {
        return $this->sub;
    }

    /**
     * @param string $sub
     */
    public function setSub($sub)
    {
        $this->sub = $sub;
    }

    /**
     * @return string
     */
    public function getAud()
    {
        return $this->aud;
    }

    /**
     * @param string $aud
     */
    public function setAud($aud)
    {
        $this->aud = $aud;
    }

    /**
     * @return int
     */
    public function getIat()
    {
        return $this->iat;
    }

    /**
     * @param int $iat
     */
    public function setIat($iat)
    {
        $this->iat = (int) $iat;
    }

    /**
     * @return int
     */
    public function getExp()
    {
        return $this->exp;
    }

    /**
     * @param int $exp
     */
    public function setExp($exp)
    {
        $this->exp = (int) $exp;
    }

    /**
     * @return int
     */
    public function getAuthTime()
    {
        return $this->auth_time;
    }

    /**
     * @param int $auth_time
     */
    public function setAuthTime($auth_time)
    {
        $this->auth_time = (int) $auth_time;
    }

    /**
     * @return string
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * @param string $scope
     */
    public function setScope($scope)
    {
        $this->scope = trim($scope);
    }
}
