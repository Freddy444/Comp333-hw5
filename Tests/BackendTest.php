<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\SessionCookieJar;

final class BackendTest extends TestCase
{
    private $client;
    private $cookieJar;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new Client(["base_uri" => "http://localhost:80"]);
        $this->cookieJar = new SessionCookieJar('cookie_file', true);
    }

    // Helper method to convert parameters to JSON
    private function toJson(array $parameters): string
    {
        return json_encode($parameters);
    }

    // Helper method to perform a POST request
    private function performPostRequest(string $url, array $parameters, array $headers = []): array
    {
        $response = $this->client->request('POST', $url, [
            'body' => $this->toJson($parameters),
            'headers' => array_merge(['Content-Type' => 'application/json'], $headers),
            'cookies' => $this->cookieJar,
        ]);

        $statusCode = $response->getStatusCode();
        $responseBody = $response->getBody()->getContents();
        return ['statusCode' => $statusCode, 'body' => json_decode($responseBody, true)];
    }

    public function testPOST_CreateUser(): void
    {
        // Change the username before every test. This is to ensure that the test will pass.
        // If you don't change the username, the test will fail because the username already exists.
        $parameters = [
            'username' => 'usercreatetest',
            'password' => '123',
            'confirm_password' => '123',
        ];

        $response = $this->performPostRequest('index.php/user/register', $parameters);

        $this->assertEquals(200, $response['statusCode']);
        $this->assertTrue($response['body']['success']);
    }

    public function testPOST_LoginUser(): void
    {
        //insert parameters of an existing account in your database for the tests to pass
        $parameters = [
            'username' => 'usercreatetest',
            'password' => '123',
        ];

        $response = $this->performPostRequest('index.php/user/login', $parameters);

        $this->assertEquals(200, $response['statusCode']);
        $this->cookieJar = $this->client->getConfig('cookies');
        $this->assertTrue($response['body']['success']);
    }

    public function testPOST_FailedLogin(): void
    {
        //insert the wrong parameters for the test to pass (failing to login)
        $parameters = [
            'username' => 'usercreatetest',
            'password' => '1234', // Input a wrong password
        ];

        $response = $this->performPostRequest('index.php/user/login', $parameters);

        $this->assertEquals(200, $response['statusCode']);
        $this->assertFalse($response['body']['success']);
    }

    public function testGet_SongList(): void
    {
        $response = $this->client->request('GET', 'index.php/music/list');
        $this->assertEquals(200, $response->getStatusCode());

        $content = $response->getBody()->getContents();
        $jsonArray = json_decode($content, true);

        $this->assertIsArray($jsonArray);

        foreach ($jsonArray as $item) {
            $this->assertArrayHasKey('id', $item);
            $this->assertArrayHasKey('username', $item);
            $this->assertArrayHasKey('artist', $item);
            $this->assertArrayHasKey('song', $item);
            $this->assertArrayHasKey('rating', $item);
        }
    }

    public function testPOST_NewSong(): void
    {
        //Chnage the song before every test for the test to not fail
        //If you don't change the song, the test will fail because the song already exists.
        $parameters = [
            'artist' => 'newsongtest',
            'song' => 'newsongtest',
            'rating' => '5',
        ];

        $response = $this->performPostRequest('index.php/music/create', $parameters);

        $this->assertEquals(200, $response['statusCode']);
        $this->assertTrue($response['body']['success']);
    }

    public function testPOST_UpdateSong(): void
    {
        //Make sure to  only update a song that exists in your database and under the 
        //username you are using for the tests. Or else the test will fail.
        $parameters = [
            'id' => 36, //chnage to the id of the song you want you want to update but make sure its of the user you are logged into (the user you used ot test the login feature)
            'artist' => 'updatetest',
            'song' => 'updatetest',
            'rating' => '1',
        ];

        $response = $this->performPostRequest('index.php/music/update', $parameters);

        $this->assertEquals(200, $response['statusCode']);
        $this->assertTrue($response['body']['success']);
    }

    public function testPOST_DeleteSong(): void
    {
        //Make sure to  only delete a song that exists in your database and under the
        //username you are using for the tests. Or else the test will fail.
        //change the id before every test for the test to not fail
        $parameters = [
            'id' => 4, //cange to the sosng you want to delete but it has to be under the user logged in
        ];

        $response = $this->performPostRequest('index.php/music/delete', $parameters);

        $this->assertEquals(200, $response['statusCode']);
        $this->assertTrue($response['body']['success']);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->client = null;
    }
}
