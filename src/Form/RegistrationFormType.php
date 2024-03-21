<?php

namespace App\Form;

use App\Entity\Participant;
use App\Entity\Site;
use Doctrine\ORM\Query\Expr\Select;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class RegistrationFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class, [

                'data' => 'update farceurs',
            ])
            ->add('nom', TextType::class, [

                'data' => 'joker',
            ])
            ->add('prenom', TextType::class, [

                'data' => 'batman',
            ])
            ->add('telephone')
            ->add('email', TextType::class, [

                'data' => 'update@farceurs.com',
            ])
            ->add('sites', EntityType::class, [
                'label' => 'Site',
                'choice_label' => 'nom',
                'class' => Site::class,
//                'data' => $this->security->getParticipant()->getSite()
            ])
            ->add('plainPassword', RepeatedType::class, [

                'mapped' => false,
                'type' => PasswordType::class,
                'attr' => ['autocomplete' => 'new-password'],
                'first_options' => [
                    'label' => 'Mot de passe',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez entrer un mot de passe',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Your password should be at least {{ limit }} characters',

                            'max' => 4096,
                        ]),
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmer le mot de passe',
                ],
                'invalid_message' => 'Les mots de passe ne sont pas identiques',

            ])
            ->add('submit', SubmitType::class, [

                'label' => 'Créer mon compte',
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
