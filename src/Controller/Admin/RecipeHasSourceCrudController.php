<?php

namespace App\Controller\Admin;

use App\Entity\RecipeHasSource;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RecipeHasSourceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RecipeHasSource::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new(propertyName: 'id')->hideOnForm(),
            UrlField::new(propertyName: 'url'),
            AssociationField::new(propertyName: 'recipe'),
            AssociationField::new(propertyName: 'source'),
        ];
    }
    
}
