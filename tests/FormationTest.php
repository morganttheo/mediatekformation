<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests;

use App\Entity\Formation;
use DateTime;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;

/**
 * Description of FormationTest
 *
 * @author theom
 */
class FormationTest extends TestCase {
    public function testGetPublishedAtString(){
        $formation = new Formation();
        $formation->setPublishedAt(new DateTime("2023-01-04 17:00:12"));
        $this->assertEquals("04/01/2023", $formation->getPublishedAtString());  
    }
}
