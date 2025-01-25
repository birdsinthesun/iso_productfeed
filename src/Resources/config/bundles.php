<?php

// config/bundles.php

return [
    // Symfony Kern-Bundles
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],      // Symfony Framework
    Symfony\Bundle\TwigBundle\TwigBundle::class => ['all' => true],                // Twig Templating
    Symfony\Bundle\SecurityBundle\SecurityBundle::class => ['all' => true],        // Sicherheitsfunktionen
    Symfony\Bundle\MonologBundle\MonologBundle::class => ['all' => true],          // Logging
    Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle::class => ['all' => true],  // E-Mail-Funktionalität
    Symfony\Bundle\WebpackEncoreBundle\WebpackEncoreBundle::class => ['all' => true], // Webpack-Integration
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => ['all' => true],       // Doctrine ORM
    Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class => ['all' => true], // Datenbank-Migrationen
    Symfony\Bundle\RoutingBundle\RoutingBundle::class => ['all' => true],          // Routing Bundle (optional, da FrameworkBundle dies meist abdeckt)

    // Contao Bundles
    Contao\ManagerBundle\ContaoManagerBundle::class => ['all' => true],            // Contao Manager
    Contao\CoreBundle\ContaoCoreBundle::class => ['all' => true],                  // Contao Core
    Contao\CalendarBundle\ContaoCalendarBundle::class => ['all' => true],          // Kalender
    Contao\NewsBundle\ContaoNewsBundle::class => ['all' => true],                  // News
    Contao\CommentsBundle\ContaoCommentsBundle::class => ['all' => true],          // Kommentare

    // Zusätzliche Bundles (falls benötigt)
    Terminal42\LeadsBundle\Terminal42LeadsBundle::class => ['all' => true],        // Leads-Management
    Codefog\HasteBundle\HasteBundle::class => ['all' => true],                     // Haste Utility
    Contao\FaqBundle\ContaoFaqBundle::class => ['all' => true],                    // FAQ
    Contao\ListingBundle\ContaoListingBundle::class => ['all' => true],            // Listenansicht
    Contao\FormBundle\ContaoFormBundle::class => ['all' => true],                  // Formulare

    // Ihr eigenes Bundle
    Bits\IsoProductfeed\IsoProductfeedBundle::class => ['all' => true],            // Ihr Bundle für XML-Feeds
];

