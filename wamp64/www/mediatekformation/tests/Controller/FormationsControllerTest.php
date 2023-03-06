<?php



namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of FormationsControllerTest
 *
 * @author Kalwin
 */
class FormationsControllerTest extends WebTestCase {
    
    private const FORMATIONURL = '/formations'; 
    /**
     * Teste l'acces de la page des formations
     */
    public function testAccesPage() {
        $client = static::createClient();
        $client->request('GET', self::FORMATIONURL);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        
    }
    
    /**
     * Test le tri dans le sens croissant des formations 
    */ 
    public function testFormationsTriASC() {
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations/tri/title/ASC');
        $this->assertSelectorTextContains('th', 'formation');
        $this->assertCount(5, $crawler->filter('th'));
        $this->assertSelectorTextContains('h5', 'Android Studio (complément n°1) : Navigation Drawer et Fragment');
    }
    
    /**
     * Test le tri dans le sens croissant des playlists 
    */ 
    public function testPlaylistsTriASC() {
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations/tri/name/ASC/playlist');
        $this->assertSelectorTextContains('th', 'formation');
        $this->assertCount(5, $crawler->filter('th'));
        $this->assertSelectorTextContains('h5', 'Bases de la programmation n°74 - POO : collections');
    }
    
    /**
     * Teste le lien d'une photo pour aller vers une formation
     */
    public function testLinkFormations() {
        $client = static::createClient();
        $client->request('GET',self::FORMATIONURL);
        $client->clickLink("L'image en miniature des formations");
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals('/formations/formation/1', $uri);
    }
    
    /**
     * Teste le filtre des formations en recherchant une formation
     */
    public function testFiltreFormations() {
        $client = static::createClient();
        $client->request('GET',self::FORMATIONURL);
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'Eclipse'
        ]); 
        $this->assertCount(9, $crawler->filter('h5'));
        $this->assertSelectorTextContains('h5', 'Eclipse');
    }
    
    /**
     * Teste le filtre des playlist en recherchant des formations 
     */
    public function testFiltrePlaylist() {
        $client = static::createClient();
        $client->request('GET','/formations/recherche/name/playlist');
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'Cours'
        ]); 
        $this->assertCount(27, $crawler->filter('h5'));
        $this->assertSelectorTextContains('h5', 'Cours'); 
    }
    
    /**
     * Teste le filtre des categories en recherchant les playlists correspondant
     */
    public function testFiltreCategorie() {
        $client = static::createClient();
        $client->request('GET','/formations/recherche/id/categories');
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'Java'
        ]); 
        $this->assertCount(7, $crawler->filter('h5'));
        $this->assertSelectorTextContains('h5', 'Java');
       
    }
}

