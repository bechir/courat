<?php

/*
 * This file is part of the COURAT application.
 *
 * (c) Bechir Ba and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultControllerTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        self::ensureKernelShutdown();
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider()
    {
        self::bootKernel();
        $container = self::$kernel->getContainer();
        $router = $container->get('router');
        $router->getContext()->setScheme($container->getParameter('router.request_context.scheme'));
        // $router->getContext()->setHost($container->getParameter('router.request_context.host'));
        // $router->getContext()->setHttpPort($container->getParameter('router.request_context.port'));
        // $router->getContext()->setHttpPort('8000');

        $makeUrl = function ($path, $parameters = []) use ($router) {
            return $router->generate($path, $parameters, UrlGeneratorInterface::ABSOLUTE_URL);
        };

        $urls = [
            // Homepage
            $makeUrl('index.fr'), // Frensh version of the homepage
            $makeUrl('index.ar'), // Arabic version of the homepage

            // Section level pages
            $makeUrl('course_index.fr', ['name' => '6af']),
            $makeUrl('course_index.ar', ['name' => '4as']),
            $makeUrl('course_index.ar', ['name' => 'terminaleC']),
            $makeUrl('course_index.fr', ['name' => 'terminaleD']),
            $makeUrl('course_index.ar', ['name' => 'terminaleLO']),
            $makeUrl('course_index.ar', ['name' => 'terminaleLM']),
        ];

        return [...array_map(fn ($url) => [$url], $urls)];
    }
}
