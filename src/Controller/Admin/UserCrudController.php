<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            Field::new('email'),
            Field::new('forename'),
            Field::new('surname'),
            DateField::new('dateOfBirth')->setFormat('d-M-Y'),
            Field::new('placeOfBirth'),
            Field::new('PESEL'),
            Field::new('isVerified'),
            Field::new('password')->onlyWhenCreating(),
        ];
    }
}
