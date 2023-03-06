<?php



namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of AcceuilControllerTest
 *
 * @author kalwin
 */
class AccueilControllerTest extends WebTestCase {
    
    /**
     * Teste l'acces de la page d'accueil
     */
    public function testAccesPage() {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        
    }
    
}