<?php

namespace App\Controller\Admin;

use App\Entity\Recipe;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class RecipeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Recipe::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('slug')->hideOnForm(),
            TextField::new('name'),
            TextField::new('subText'),
            NumberField::new('totalTime'),
            UrlField::new('sourceUrl')->onlyOnForms(),
            ArrayField::new('ingredients')->onlyOnForms(),
            ArrayField::new('instructions')->onlyOnForms(),
        ];
    }
}
