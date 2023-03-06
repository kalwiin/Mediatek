<?php


namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;


/**
 * Description of PlaylistsControllerTest
 *
 * @author kalwin
 */
class PlaylistsControllerTest extends WebTestCase {
    
    /**
     * Teste l'acces de la page des playlists
     */
    public function testAccesPage() {
        $client = static::createClient();
        $client->request('GET', '/playlists');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        
    }
    
    
    /**
     * Test le tri dans le sens croissant des playlists 
    */ 
    public function testPlaylistsTriASC() {
        $client = static::createClient();
        $crawler = $client->request('GET', '/playlists/tri/name/ASC');
        $this->assertSelectorTextContains('th', 'Playlist');
        $this->assertCount(4, $crawler->filter('th'));
        $this->assertSelectorTextContains('h5', 'Bases de la programmation (C#)');
    }
    
    /**
     * Test le tri dans le sens croissant des playlists 
    */ 
    public function testPlaylistsTriNbformationASC() {
        $client = static::createClient();
        $crawler = $client->request('GET', '/playlists/tri/nbformations/ASC');
        $this->assertSelectorTextContains('th', 'Playlist');
        $this->assertCount(4, $crawler->filter('th'));
        $this->assertSelectorTextContains('h5', 'Cours Informatique embarquée');
    }
    
    
    /**
     * Teste le lien du bouton voir détail pour aller vers une formation
     */
    public function testLinkPlaylists() {
        $client = static::createClient();
        $client->request('GET','/playlists');
        $client->clickLink('Voir détail');
        $response = $client->getResponse();
        dd($client->getRequest());
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals('/playlists/playlist/13', $uri);
    }
    
    /**
     * Teste le filtre des playlist en recherchant une playlist
     */
    public function testFiltrePlaylist() {
        $client = static::createClient();
        $client->request('GET','/playlists/recherche/name');
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'Cours'
        ]); 
        $this->assertCount(11, $crawler->filter('h5'));
        $this->assertSelectorTextContains('h5', 'Cours');
       
    }
    
    /**
     * Teste le filtre des categories en recherchant les playlists correspondant
     */
    public function testFiltreCategorie() {
        $client = static::createClient();
        $client->request('GET','/playlists/recherche/id/categories');
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'Java'
        ]); 
        $this->assertCount(2, $crawler->filter('h5'));
        $this->assertSelectorTextContains('h5', 'Java');
       
    }
    
    
    
}