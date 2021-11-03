<?php

namespace App\Form\Type;

use App\Form\Model\DocumentosDto;
use Symfony\Component\Form\AbstractType;
//use Symfony\Component\Form\Extension\Core\Type\DateType;
//use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentosFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('tipo', TextType::class)
        ->add('user', TextType::class)
        ->add('createAt', TextType::class)
        ->add('dependent', TextType::class)
        ->add('base64Image', TextType::class)

  
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DocumentosDto::class,
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }

    public function getName(): string
    {
        return '';
    }

}
