<?php

namespace App\Form;

use App\Entity\Category;
use App\Model\SearchData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', TextType::class,[
                'label'=>false,
                'required'=>false,
                'attr'=> [
                    'placeholder'=>'Find'
                ]
            ])
            ->add('categories',EntityType::class,[
                'label'=>false,
                'required'=>false,
                'class'=>Category::class,
                'expanded'=>true,
                'multiple'=>false,
            ])
            ->add('min', IntegerType::class,[
                'label'=>false,
                'required'=>false,
                'attr'=> [
                    'placeholder'=>'Price min'
                ]
            ])
            ->add('max', IntegerType::class,[
                'label'=>false,
                'required'=>false,
                'attr'=> [
                    'placeholder'=>'Price max'
                ]
            ])
            ->add('promo', CheckboxType::class,[
                'label'=>'En Promo',
                'required'=>false,
                'attr'=> [
                    'placeholder'=>'On discount'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }
}
