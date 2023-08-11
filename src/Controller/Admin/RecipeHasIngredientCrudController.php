<?php

namespace App\Controller\Admin;

use App\Entity\RecipeHasIngredient;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RecipeHasIngredientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RecipeHasIngredient::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
