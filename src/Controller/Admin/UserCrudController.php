<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserCrudController extends AbstractCrudController
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface  $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'User ID')->hideWhenUpdating(),
            IdField::new('plainId', 'USER ID')
                ->onlyOnForms()
                ->setFormTypeOption('disabled', true),
            EmailField::new('email'),
            ChoiceField::new('roles')
            ->setChoices([
                'Super admin'    => 'ROLE_SUPER_ADMIN',
                'Administrateur' => 'ROLE_ADMIN',
            ])
            ->setRequired(isRequired:false)
            ->allowMultipleChoices(),
            AssociationField::new('recipes')
            ->setFormTypeOptions([
                'by_reference' => false,
            ]),
            TextField::new(propertyName: 'password')->onlyOnIndex(),
            TextField::new(propertyName: 'plainPassword')->onlyOnForms(),
        ];
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof User && $plainPassword = $entityInstance->getPlainPassword()) {
            $hashedPassword = $this->passwordHasher->hashPassword($entityInstance, $plainPassword);
            $entityInstance->setPassword($hashedPassword);
            $entityInstance->setPlainPassword(null); // Remove plain password
        }

        parent::updateEntity($entityManager, $entityInstance);
    }
   
}
