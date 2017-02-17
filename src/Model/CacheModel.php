<?php
namespace NYPL\Services\Model;

use NYPL\Starter\Model;
use NYPL\Starter\Model\ModelTrait\CacheReadTrait;
use NYPL\Starter\Model\ModelTrait\CacheTrait;
use NYPL\Starter\Model\ModelTrait\TranslateTrait;

abstract class CacheModel extends Model
{
    use CacheReadTrait, CacheTrait, TranslateTrait;
}
