<?php

/*
 * This file is part of the COURAT application.
 *
 * (c) Bechir Ba and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ApiTestCase extends WebTestCase
{
    const BASE_PATH = '/api/';
    const RESPONSE_CONTENT_TYPE = 'application/json';

    protected $client;

    public function setUp(): void
    {
        parent::setUp();

        self::ensureKernelShutdown();
        $this->client = static::createClient();
    }

    public function assertResponse()
    {
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', self::RESPONSE_CONTENT_TYPE, 'The content type must be ' . self::RESPONSE_CONTENT_TYPE);
    }

    /**
     * @param $expectedJson
     */
    public function assertJsonResponse(Response $response, string $expectedJson)
    {
        $this->assertJsonStringEqualsJsonString($expectedJson, $response->getContent());
    }
}
