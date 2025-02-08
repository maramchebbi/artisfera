<?php

namespace App\Form;

use App\Entity\Peinture;
use App\Entity\Style;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddEditPeintureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('date_cr', null, [
                'widget' => 'single_text',
            ])
            ->add('tableau')
            ->add('type', EntityType::class, [
                'class' => Style::class,
                'choice_label' => 'type_p',
            ])
            ->add('Envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Peinture::class,
        ]);
    }
}
