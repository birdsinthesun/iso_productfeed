<?php

namespace Bits\IsoProductfeed\Contao;

use Contao\DC_Table;
use Contao\System;
use Contao\Environment as ContaoEnvironment;
use Twig\Environment;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Bits\IsoProductfeed\Form\FeedbackType;


class DC_IsoProductfeed extends DC_Table
{
    protected $strTable = 'tl_iso_productfeed';

    public function __construct($strTable)
    {
        parent::__construct($strTable);
    }

    public function showAll()
    {
        
        // Hole die aktuelle Request aus dem Symfony-Container
        $request = System::getContainer()->get('request_stack')->getCurrentRequest();

        return $this->generateForm($request) . parent::showAll();
    }

    private function processForm(array $data)
    {
        // Daten speichern oder verarbeiten
        return 'Formular erfolgreich verarbeitet.';
    }

    public function generateForm($request)
    {
        // Formular erstellen
        $container = System::getContainer();
        $formFactory = $container->get('form.factory');
        $csrfTokenManager = $container->get(CsrfTokenManagerInterface::class); // Zugriff auf den CSRF-Manager
        $csrfToken = $csrfTokenManager->getToken('feedback_form')->getValue();

        $form = $formFactory->create(FeedbackType::class, null, [
       // 'action' => ContaoEnvironment::get('base').ContaoEnvironment::get('request')
        'csrf_token' => $csrfToken,
            ]);

//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $data = $form->getData();
//            return $this->processForm($data);
//        }

        $twig = $container->get('twig');

        return $twig->render('@Contao/iso_productfeed_panel.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}