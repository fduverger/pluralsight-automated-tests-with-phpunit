<?php
require __DIR__. "/../../../vendor/autoload.php";
use Goutte\Client as GoutteClient;
use GuzzleHttp\Client as GuzzleClient;
use PHPUnit\Framework\TestCase;

class GameControllerTest extends TestCase 
{
    public function testIndexHasUl()
    {
        $client = new GoutteClient();
        $response = $client->request('GET', 'http://0.0.0.0:8000');
        $this->assertCount(6, $response->filter('ul > li'));
    }

    public function testAddRatingWithGetHasEmptyForm()
    {
        $client = new GoutteClient();
        $response = $client->request('GET',
        "http://0.0.0.0:8000/add-rating.php?game=1");

        $this->assertCount(1, $response->filter('form'));
        $this->assertEquals('', 
            $response->filter('form input[name=score]')->attr('value'));
    }

    public function testAddRatingWithPostIsRedirected()
    {
        $client = new GuzzleClient();
        $response = $client->request('POST',
        "http://localhost:8000/add-rating.php?game=1",
            array(
                'multipart' => array(
                    array(
                        'name' => 'score',
                        'contents' => 5,
                    ),
                    array(
                        'name' => 'screenshot',
                        'contents' => fopen(__DIR__.'/screenshot.jpg', 'r')
                    ),
                ),
                'allow_redirects' => false,
                )
        );

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals('/', $response->getHeaderLine('Location'));

        $pdo = new PDO(
            "mysql:host=localhost;dbname=gamebook_tests",
            'root',
            '123...abc'
        );

        $statement = $pdo->prepare('SELECT * FROM rating');
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $this->assertCount(1, $result);
        $this->assertEquals([
            'user_id' => 1,
            'game_id' => 1,
            'score' => 5,
        ], $result[0]);

        $this->assertFileExists(
            __DIR__.'/../../../web/screenshots/1-1.jpg'
        );
    }

    public function testApiGameWithUsersReturns6Items()
    {
        $client = new GuzzleClient();
        $response = $client->request(
            'GET',
            'http://0.0.0.0:8000/api-games.php',
            array(
                'json' => array(
                    'user' => 1
                )
            ));

            $json = $response->getBody()->getContents();
            $this->assertJsonStringEqualsJsonString(
                file_get_contents(__DIR__.'/api-games-user.json'), $json
            );
    }
}