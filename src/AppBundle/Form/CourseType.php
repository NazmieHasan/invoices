<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('startDate', DateType::class,
                [
                    'widget' => 'single_text',
                    'format' => 'dd.MM.yyyy',
                    'invalid_message' => "Невалидна дата! Моля, опитайте с 'ДД.ММ.ГГГГ'",
                ])
            ->add('finishDate', DateType::class,
                [
                    'widget' => 'single_text',
                    'format' => 'dd.MM.yyyy',
                    'invalid_message' => "Невалидна дата! Моля, опитайте с 'ДД.ММ.ГГГГ'",
                ])
            ->add('price', TextType::class)
            ->add('priceText', TextType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Course'
        ));
    }

}
