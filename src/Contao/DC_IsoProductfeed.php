<?php

namespace Bits\IsoProductfeed\Contao;

use Contao\DC_Table;
use Contao\System;
use Contao\Environment as ContaoEnvironment;
use Twig\Environment;
use Contao\CoreBundle\Security\ContaoCsrfTokenManager;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Bits\IsoProductfeed\Form\FeedbackType;


class DC_IsoProductfeed extends DC_Table
{
    protected $strTable = 'tl_iso_productfeed';

    public function __construct( $strTable
            ){
            
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
        // Hole den CSRF-Token-Manager aus dem Container
        $csrfTokenManager = System::getContainer()->get('contao.csrf.token_manager');
        $csrfTokenId = System::getContainer()->getParameter('contao.csrf_token_name');
        
        $form = $formFactory->create(FeedbackType::class, null, [
            'action' => $request->getUri(),
            'csrf_protection' => true,
            'csrf_field_name' => 'REQUEST_TOKEN',
            'csrf_token_id'   => $csrfTokenId,
             'attr' => [
                    'id' => 'feedback_form', // Setzt die ID des Formulars
                    'name' => 'feedback_form', // Setzt die ID des Formulars
                ],
            'csrf_token_manager' => $csrfTokenManager
           
        ]);
        
        //var_dump($csrfTokenId.'1: '. $csrfTokenManager->getToken($csrfTokenId)->getValue());
       
        $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
          //  var_dump('Submitted Token: ' . $request->request->get('REQUEST_TOKEN'));

          //  var_dump($data);exit;
            return $this->processForm($data);
        }

        $twig = $container->get('twig');

        return $twig->render('@Contao/iso_productfeed_panel.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
