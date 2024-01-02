<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests;

use App\Entity\Formation;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Description of FormationValidationTest
 *
 * @author theom
 */
class FormationValidationTest extends KernelTestCase {
    public function getFormation(): Formation{
        return (new Formation())
                    ->setTitle("vidéo 2")
                    ->setVideoId("najzrf");
    }
    
    public function testValidDateFormation(){
        $formation = $this->getFormation()->setPublishedAt(new DateTime("2023-05-10 17:00:15"));
        $this->assertErrors($formation,0);

    }
     public function testNonValidDateFormation(){
        $formation = $this->getFormation()->setPublishedAt(new DateTime("2025-05-10 17:00:15"));
        $this->assertErrors($formation,1);

    }
    public function assertErrors(Formation $formation, int $nbErreursAttendues){
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $error = $validator->validate($formation);
        $this->assertCount($nbErreursAttendues,$error);
        
    }
}
