<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Validations;

use App\Entity\Formation;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use DateTime;
use Symfony\Component\Validator\Validator\ValidatorInterface;


/**
 * Description of FormationValidationTest
 *
 * @author kalwi
 */
class FormationValidationTest extends KernelTestCase{
     
    /*
     * Recupere une formation
     */
    public function getFormation() : Formation 
    {
        return(new Formation ())
                ->setTitle('Formation pour le test')
                ->setPublishedAt(new DateTime("2022/02/20"));  
    }
    
     /*
     * Teste une date valide
     */
    public function testValidDateFormation(){
        $formation = $this->getFormation()->setPublishedAt(new DateTime("2022/02/20"));
        $this->assertErrors($formation,0);
    }
    
     /*
     *  Récupération d'erreur
     */
    
     public function assertErrors(Formation $formation, int $nbErreursAttendues,string $message=""){
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $error = $validator->validate($formation);
        $this->assertCount($nbErreursAttendues,$error,$message);
    }
}
