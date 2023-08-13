<?php

namespace App\Form;

use App\Entity\Unit;
use App\Entity\Ingredient;
use App\Entity\IngredientGroup;
use App\Entity\RecipeHasIngredient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class RecipeHasIngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity', type: NumberType::class)
            ->add('optional', type: CheckboxType::class)
            ->add('ingredient', type: EntityType::class, options: [
                'class'=> Ingredient::class,
            ])
            ->add('ingredientGroup', type: EntityType::class, options: [
                'class'=> IngredientGroup::class,
            ])
            ->add('unit', type: EntityType::class, options: [
                'class'=> Unit::class,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RecipeHasIngredient::class,
        ]);
    }
}
