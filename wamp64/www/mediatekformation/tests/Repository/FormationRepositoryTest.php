<?php


namespace App\Tests\Repository;

use App\Entity\Formation;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Description of FormationRepositoryTest
 *
 * @author kalwi
 */
class FormationRepositoryTest extends KernelTestCase{
     
    /**
     * Réécupère le repository de Formation
     * @return FormationRepository
     */
    public function recupRepository(): FormationRepository {
        self::bootKernel();
        $repository = self::getContainer()->get(FormationRepository::class);
        return $repository;  
    }

    /**
     * Test le nombre d'enregistrement des formations
     */
     public function testNbFormation() {
       
        $repository = $this->recupRepository();
        $nbFormations = $repository->count([]);
        $this->assertEquals(240, $nbFormations);
    }
      /*
     * Création d'une instance de Formation
     * @return Formation
     */
    public function newFormation(): Formation{
        $formation = (new Formation())
                ->setTitle('Formation pour le test')
                ->setPublishedAt(new \DateTime("02/20/2022"))
                ->setDescription("Description test du test d'intégration");
        return $formation;
    }
    
    /*
     * Teste l'ajout d'une Formation
     */

    public function testAddFormation(){
        $repository = $this->recupRepository();
        $formation = $this->newformation();
        $nbFormations = $repository->count([]);
        $repository->add($formation, true);
        $this->assertEquals($nbFormations + 1, $repository->count([]), "erreur lors de l'ajout");
    }
        /*
     * Teste la suppression d'une Formation
     */
    public function testRemoveFormation(){
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $repository->add($formation, true);
        $nbFormations = $repository->count([]);
        $repository->remove($formation, true);
        $this->assertEquals($nbFormations - 1, $repository->count([]), "erreur lors de la suppression");        
    }

    /**
     * Teste la méthode findAllOrderBy triée sur un champ
     */
    public function testFindAllOrderby(){
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $repository->add($formation, true);
        $formations = $repository->findAllOrderBy("id", "ASC");
        $nbFormations = count($formations);
        $this->assertEquals(241, $nbFormations);
        $this->assertEquals("Eclipse n°8 : Déploiement", $formations[0]->getTitle());
    }
}
