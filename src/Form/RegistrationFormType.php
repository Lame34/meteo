<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Adresse Email',
                'attr' => [
                    'class' => 'w-full bg-[#030712] border border-white/30 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-blue-500 placeholder-gray-600 mb-4',
                    'placeholder' => 'exemple@email.com'
                ],
                'label_attr' => ['class' => 'block text-sm font-medium text-gray-300 mb-2']
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'label' => 'Mot de passe',
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'w-full bg-[#030712] border border-white/30 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-blue-500 placeholder-gray-600 mb-6',
                    'placeholder' => '••••••••'
                ],
                'label_attr' => ['class' => 'block text-sm font-medium text-gray-300 mb-2'],
                'constraints' => [
                    new NotBlank(message: 'Entrez un mot de passe'),
                    new Length(
                        min: 6,
                        max: 4096,
                        minMessage: 'Le mot de passe doit faire au moins {{ limit }} caractères',
                    ),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
