<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // By default, password is required
        $passwordOptions = array(
            'type'           => PasswordType::class,
            'first_options'  => ['label' => 'Password'],
            'second_options' => ['label' => 'Repeat Password'],
            'required'       => true
        );

        // If edit user : password is optional
        // User object is stored in $options['data']
        if (!empty($options['data']->getId())) {
            $passwordOptions['required'] = false;
        }

        $builder
            ->add('name')
            ->add('lastname')
            ->add('email')
            ->add('password', RepeatedType::class, $passwordOptions)
            ->add('active');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
