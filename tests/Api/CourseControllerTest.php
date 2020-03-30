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

class CourseControllerTest extends ApiTestCase
{
    const PATH = self::BASE_PATH . 'course/';

    public function testListing()
    {
        $response = $this->client->request('GET', self::PATH . 'list');

        $this->assertResponse();
    }
}
