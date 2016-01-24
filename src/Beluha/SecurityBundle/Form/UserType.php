<?php

namespace Beluha\SecurityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Gregwar\CaptchaBundle\Type\CaptchaType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,[
                    'label' => 'user_form.email',
                    'translation_domain' => 'security',
            ])
            ->add('username', TextType::class,[
                    'label' => 'user_form.username',
                    'translation_domain' => 'security',
            ])
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => [
                    'label' => 'user_form.password',
                    'translation_domain' => 'security'
                    ],
                'second_options' => [
                    'label' => 'user_form.repeat_password',
                    'translation_domain' => 'security',
                ],
            )
        )
            ->add('captcha', CaptchaType::class, [
                'width' => 200,
                'height' => 50,
                'length' => 6,
                'as_url' => TRUE,
                'reload' => TRUE,
                'background_color' => [243, 243, 243],
                'label' => 'user_form.captcha',
                'translation_domain' => 'security'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Beluha\SecurityBundle\Entity\User'
        ));
    }
}

