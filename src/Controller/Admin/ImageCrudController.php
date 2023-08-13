<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Field\VichImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class ImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Image::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextareaField::new('title'),
            IntegerField::new('size'),
            VichImageField::new('imageFile'),
            IntegerField::new('priority'),
            AssociationField::new('recipe'),
            AssociationField::new('step'),
       ];
    }
   
}
