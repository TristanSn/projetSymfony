<?php

namespace App\Form;

use App\Dto\RechercheDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('input', null, array(
                'attr' => array('placeholder' => 'Rechercher un film ou une série'
                , 'style' => 'width: 600px; margin-top: 20px; margin-left: 400px'),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RechercheDto::class,
        ]);
    }
}
