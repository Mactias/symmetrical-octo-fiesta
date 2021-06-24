<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BookCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Book::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            'title',
            'author',
            Field::new('publisher'),
            Field::new('publicationYear')->setLabel('P. Year'),
            Field::new('subject'),
            Field::new('genre'),
            Field::new('isbn'),

            FormField::addPanel('Loan Details'),
            AssociationField::new('loanedBy')->hideOnIndex(),
            IntegerField::new('loan')->hideOnIndex(),
            DateField::new('returnDate')->setLabel('Return')->setFormat('d-M-Y')->hideOnIndex(),
        ];
    }
}
