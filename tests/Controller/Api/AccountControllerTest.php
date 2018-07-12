<?php

namespace App\Controller\Api;

use Metin2Domain\Account\Login;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AccountControllerTest extends WebTestCase {

    public function testCreateActionWithInvalidFormats() {
        $schemas = array(
            [
                ''
            ],
            [
                'something' => [
                    'something-else' => 123
                ]
            ],
            [
                'account' => [
                    'login' => 'validLogin',
                    'password' => 'validPasswd',
                    'socialId' => '1231231',
                    'missing-email' => ''
                ]
            ],
            [
                'account' => [
                    'password' => 'validPasswd',
                    'socialId' => '1231231',
                    'email' => 'email@email.it'
                ]
            ],
            [
                'account' => [
                    'login' => 'validLogin',
                    'socialId' => '1231311',
                    'email' => 'email@email.it'
                ]
            ],
            [
                'account' => [
                    'login' => 'validLogin',
                    'socialId' => ['wrongFormat'],
                    'password' => 'validPasswd',
                    'email' => 'email@email.it'
                ]
            ]
        );


        foreach($schemas as $schema) {
            $client = static::createClient();
            $client->request(
                'POST',
                '/api/accounts',
                array(),
                array(),
                array(),
                json_encode($schema)
            );
            $this->assertEquals(400,$client->getResponse()->getStatusCode());
        }
    }

    public function testCreateActionOK(){
        $client = static::createClient();

        do {
            $schema = array (
                'account' => [
                    'login' => 'test'.substr(
                        str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'),
                        0,
                        Login::MAX_LENGTH - 4),
                    'password' => 'ciao123',
                    'socialId' => '1231231',
                    'email' => 'email@email.it'
                ]
            );
            $client->request(
                'POST',
                '/api/accounts',
                array(),
                array(),
                array(),
                json_encode($schema)
            );

        } while ($client->getResponse()->getStatusCode() == 409);

        $this->assertEquals(201, $client->getResponse()->getStatusCode());

        return [
            'location' => $client->getResponse()->headers->get('Location'),
            'schema' => $schema
            ];
    }

    /**
     * @depends testCreateActionOK
     * @param array $locationAndSchema
     */
    public function testGetActionStatusOK(array $locationAndSchema) {
        $client = static::createClient();
        $client->request('GET', $locationAndSchema['location']);

        $response = $client->getResponse();
        $decodedContent = json_decode($response->getContent(), true);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($locationAndSchema['schema']['account']['login'], $decodedContent['account']['login']);
        $this->assertEquals($locationAndSchema['schema']['account']['email'], $decodedContent['account']['email']);
    }

    /**
     * @depends testCreateActionOK
     * @param array $locationAndSchema
     */
    public function testChangePasswordAction(array $locationAndSchema) {

        //Remember old password
        $oldPassword = $locationAndSchema['schema']['account']['password'];

        //Change to a new password
        $schema = array(
            'password' => 'new-password'
        );
        $location = rtrim($locationAndSchema['location'], '/'). '/password';
        $client = static::createClient();
        $client->request(
            'PUT',
            $location,
            array(),
            array(),
            array(),
            json_encode($schema)
        );

        $statusCode = $client->getResponse()->getStatusCode();

        //Reset the password to the old one
        $client->request(
            'PUT',
            $location,
            array(),
            array(),
            array(),
            json_encode([
                'password' => $oldPassword
            ])
        );

        $this->assertEquals(200,$statusCode);
    }

    /**
     * @depends testCreateActionOK
     * @param array $locationAndSchema
     */
    public function testChangeEmailAction(array $locationAndSchema) {

        //Remember old email
        $oldEmail = $locationAndSchema['schema']['account']['email'];

        //Change to a new email
        $schema = array(
            'email' => 'new-email@email.it'
        );
        $location = rtrim($locationAndSchema['location'], '/'). '/email';
        $client = static::createClient();
        $client->request(
            'PUT',
            $location,
            array(),
            array(),
            array(),
            json_encode($schema)
        );

        $statusCode = $client->getResponse()->getStatusCode();

        //Reset the password to the old one
        $client->request(
            'PUT',
            $location,
            array(),
            array(),
            array(),
            json_encode([
                'email' => $oldEmail
            ])
        );

        $this->assertEquals(200,$statusCode);
    }

}
