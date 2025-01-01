<?php

namespace Bits\IsoProductfeed\Form;

use Contao\System;
use Bits\IsoProductfeed\Entity\Feedback;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;


class FeedbackType extends AbstractType
{
    
    
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       
            $container = System::getContainer();
            $formFactory = $container->get('form.factory');
            $builder
            ->add('name')
            ->add('email')
            ->add('message')
            ->add('FORM_SUBMIT', HiddenType::class, [
                'property_path' => null,
                'mapped' => false, 
                'attr' => [                // Setzt den HTML-Name des Feldes
                    'id' => 'FORM_SUBMIT',
                    'name' => 'FORM_SUBMIT',
                    'full_name' => 'FORM_SUBMIT',
                     'value' => 'feedback_form',
                ],
               
                'data' => 'feedback_form', // Möglichkeit, CSRF-Token als Option zu übergeben
            ])
            ->add('REQUEST_TOKEN', HiddenType::class, [
                'property_path' => null,
                'mapped' => false, 
                'attr' => [                // Setzt den HTML-Name des Feldes
                    'id' => 'REQUEST_TOKEN',
                    'name' => 'REQUEST_TOKEN',
                    'full_name' => 'REQUEST_TOKEN',
                     'value' => $options['csrf_token_manager']->getToken('feedback_form')->getValue(),
                ],
               
                'data' => $options['csrf_token_manager']->getToken('feedback_form')->getValue(), // Möglichkeit, CSRF-Token als Option zu übergeben
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Senden',
                'attr' => [                // Setzt den HTML-Name des Feldes
                     'value' => 'feedback_form'
                ]
            ]);
        
    }
     public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_token_manager' => null, // Erforderlich, um den CSRF-Token-Manager zu übergeben
        ]);
    }


    public function getBlockPrefix()
        {
            return ''; // Keine Präfixierung
        }
}
