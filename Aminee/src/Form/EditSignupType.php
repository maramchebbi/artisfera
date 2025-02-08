<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\SignUp;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class EditSignupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom')
            ->add('nom')
            ->add('date_de_naissance', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['max' => date('Y-m-d')], 
            ])
            ->add('email')
            ->add('pwd')
            ->add('Genre', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'G',
            ]) 
            ->add('Type', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'T',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->where('t.T != :admin')
                        ->setParameter('admin', 'admin'); 
                },
            ])          
            ->add('Edit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SignUp::class,
        ]);
    }
}
