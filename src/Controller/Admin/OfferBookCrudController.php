<?php

namespace App\Controller\Admin;

use App\Entity\OfferBook;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OfferBookCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OfferBook::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextField::new('author'),
            TextField::new('publishingHause'),
            TextField::new('placeOfPublication'),
            IntegerField::new('DateOfPublication'),
            IntegerField::new('page'),
            AssociationField::new('user'),
            TextareaField::new('description'),
            BooleanField::new('isAccept')
        ];
    }
}
