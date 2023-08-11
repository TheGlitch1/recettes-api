<?php

namespace App\Controller\Admin;

use App\Entity\RecipeHasSource;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RecipeHasSourceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RecipeHasSource::class;
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
