<?php

namespace Bits\IsoProductfeed\Contao;

use Contao\DC_Table;
use Contao\System;
use Twig\Environment;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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

    private function generateForm($request)
    {
        $container = System::getContainer();
        $formFactory = $container->get('form.factory');
        $csrfTokenManager = $container->get('security.csrf.token_manager'); // Hole den CsrfTokenManager hier
        $csrfToken = $csrfTokenManager->getToken('iso_productfeed_form')->getValue();

        // Formular erstellen
        $form = $formFactory->createBuilder()
            ->add('name', TextType::class, [
                'label' => 'Name des Feeds',
                'required' => true,
            ])
            ->add('_token', HiddenType::class, [
                'data' => $csrfToken,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Speichern',
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            return $this->processForm($data);
        }

        $twig = $container->get('twig');

        return $twig->render('@Contao/iso_productfeed_panel.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
