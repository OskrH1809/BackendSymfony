<?php

namespace App\Form\Type;

use App\Form\Model\ContractedDto;
use Symfony\Component\Form\AbstractType;
//use Symfony\Component\Form\Extension\Core\Type\DateType;
//use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContractedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('base64Image', TextType::class)
//            ->add('dueDate', DateType::class)
//            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContractedDto::class,
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