<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use App\Entity\Book;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;

class Book2CrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Book::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['loan' => 'DESC']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            // most of the times there is no need to define the
            // filter type because EasyAdmin can guess it automatically
            ->add('loan')
            ->add('returnDate')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            'title',
            'author',
            Field::new('publisher')->hideOnIndex(),
            Field::new('publicationYear')->setLabel('P. Year')->hideOnIndex(),
            Field::new('subject')->hideOnIndex(),
            Field::new('genre')->hideOnIndex(),
            Field::new('isbn')->hideOnIndex(),

            FormField::addPanel('Loan Details'),
            AssociationField::new('loanedBy'),
            IntegerField::new('loan'),
            DateField::new('returnDate')->setFormat('d-M-Y'),
        ];
    }
}
