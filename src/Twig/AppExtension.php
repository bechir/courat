<?php

/*
 * This file is part of the COURAT application.
 *
 * (c) Bechir Ba and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Intl\Languages;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private $container;
    private $locales;
    private $localeCodes;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->localeCodes = explode('|', $container->getParameter('locales'));
    }

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('html_entity_decode', 'html_entity_decode'),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('locale', [$this, 'getLocale']),
            new TwigFunction('locales', [$this, 'getLocales']),
        ];
    }

    public function getLocale(): ?string
    {
        return $this->container->get('request_stack')->getMasterRequest()->attributes->get('_locale');
    }

    public function getLocales(): array
    {
        if (null !== $this->locales) {
            return $this->locales;
        }

        $this->locales = [];
        foreach ($this->localeCodes as $code) {
            $this->locales[] = [
                'code' => $code,
                'name' => Languages::getName($code, $code),
            ];
        }

        return $this->locales;
    }
}
