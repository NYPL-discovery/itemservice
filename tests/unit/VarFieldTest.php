<?php
namespace NYPL\Tests;

use NYPL\Services\Model\DataModel\SubField;
use NYPL\Services\Model\DataModel\VarField;
use PHPUnit\Framework\TestCase;

class VarFieldTest extends TestCase
{
    public function testTranslateSubFields()
    {
        $varField = new VarField();

        $this->assertContainsOnlyInstancesOf(
            SubField::class,
            $varField->translateSubFields([])
        );
    }
}
