<?php

/*
 * This file is part of the Rim Edu application.
 *
 * By Bechir Ba and contributors
 */

namespace App\Tests\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CourseControllerTest extends WebTestCase
{
    const BASE_PATH = '/api/course/';

    public function testLatest()
    {
        $client = static::createClient();
        $client->request('GET', self::BASE_PATH . 'latest');

        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello World');
    }
}
