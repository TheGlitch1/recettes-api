<?php

namespace App\Controller\Admin;

use App\Entity\IngredientGroup;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class IngredientGroupCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return IngredientGroup::class;
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
