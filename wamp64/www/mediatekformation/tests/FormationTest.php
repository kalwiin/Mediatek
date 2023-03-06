<?php

namespace App\Tests;

use App\Entity\Formation;
use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * Description of FormationTest
 *
 * @author kalwin
 */
class FormationTest extends TestCase {
     public function testGetPublishedAtString(){
        $formation = new Formation();
        $formation->setPublishedAt(new DateTime("2022-02-20"));
        $this->assertEquals("20/02/2022", $formation->getPublishedAtString());
    }
}
