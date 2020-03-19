<?php

namespace App\Twig;

use App\Entity\ClassLevel;
use Doctrine\ORM\EntityManagerInterface;
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
    private $entityManager;
    private $levels = null;

    public function __construct(ContainerInterface $container, EntityManagerInterface $entityManager)
    {
        $this->container = $container;
        $this->entityManager = $entityManager;
        $this->localeCodes = explode('|', $container->getParameter('locales'));
    }

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            // new TwigFilter('locales', [$this, 'getLocales']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('levels', [$this, 'getLevels']),
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
        if(null !== $this->locales) {
            return $this->locales;
        }

        $this->locales = [];
        foreach ($this->localeCodes as $code) {
            $this->locales[] = [
                'code' => $code,
                'name' => Languages::getName($code, $code)
            ];
        }

        return $this->locales;
    }

    public function getLevels()
    {
        if(!$this->levels) {
            $this->levels = $this->entityManager->getRepository(ClassLevel::class)->findAll();
        }

        return $this->levels;
    }
}
