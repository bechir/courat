<?php

/*
 * This file is part of the Rim Edu application.
 *
 * By Bechir Ba and contributors
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

        // dd($client->getResponse()->getStatusCode());

        // dd($client->getResponse());

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider()
    {
        self::bootKernel();
        $container = self::$kernel->getContainer();
        $router = $container->get('router');
        $router->getContext()->setScheme($container->getParameter('router.request_context.scheme'));
        $router->getContext()->setHost($container->getParameter('router.request_context.host'));
        $router->getContext()->setHttpPort($container->getParameter('router.request_context.port'));

        $makeUrl = function ($path, $parameters = []) use ($router) {
            return $router->generate($path, $parameters, UrlGeneratorInterface::ABSOLUTE_URL);
        };

        $urls = [
            // Homepage
            $makeUrl('index.fr'), // Frensh version of the homepage
            $makeUrl('index.ar'), // Arabic version of the homepage

            // Section level pages
            $makeUrl('section_level.fr', ['name' => 'primaire']),
            $makeUrl('section_level.ar', ['name' => 'primaire']),
            $makeUrl('section_level.fr', ['name' => 'college']),
            $makeUrl('section_level.ar', ['name' => 'college']),
            $makeUrl('section_level.fr', ['name' => 'lycee']),
            $makeUrl('section_level.ar', ['name' => 'lycee']),
            $makeUrl('section_level.fr', ['name' => 'terminale']),
            $makeUrl('section_level.ar', ['name' => 'terminale']),
        ];

        return [...array_map(fn ($url) => [$url], $urls)];
    }
}
