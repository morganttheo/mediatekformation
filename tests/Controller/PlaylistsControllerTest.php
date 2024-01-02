<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of PlaylistsControllerTest
 *
 * @author theom
 */
class PlaylistsControllerTest extends WebTestCase {
    
    
    public function testLinkPlaylist(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/playlists');
        $linkToPlaylistDetail = $crawler->filter('table.table-striped tbody tr:first-child td.text-center a.btn-secondary')->link();
        $client->click($linkToPlaylistDetail);
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals('/playlists/playlist/13', $uri);
    }
    
    public function testContenuPlaylist(){
        $client = static::createClient();
        $crawler =$client->request('GET', '/playlists/playlist/13');
        $this->assertSelectorTextContains('h4','Bases de la programmation (C#)');
    }
    
}
