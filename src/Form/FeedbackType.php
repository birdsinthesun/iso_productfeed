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
            $csrfTokenManager = $container->get('security.csrf.token_manager'); // Hole den CsrfTokenManager hier
            $csrfToken = $csrfTokenManager->getToken('feedback_form')->getValue();
            $builder
            ->add('name')
            ->add('email')
            ->add('message')
             ->add('_token', HiddenType::class, [
                'data' => $csrfToken, // Möglichkeit, CSRF-Token als Option zu übergeben
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Senden',
            ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Feedback::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'feedback_form'
        ]);
    }
}
