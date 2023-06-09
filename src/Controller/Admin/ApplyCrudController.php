<?php

namespace App\Controller\Admin;

use App\Entity\Apply;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class ApplyCrudController extends AbstractCrudController
{
  public static function getEntityFqcn(): string
  {
    return Apply::class;
  }

  public function configureFields(string $pageName): iterable
  {
    return [
      IdField::new('id')->onlyOnIndex(),
      TextField::new('name')->hideOnForm(),
      EmailField::new('email')->hideOnForm(),
      TelephoneField::new('phoneNumber')->onlyOnDetail(),
      TextareaField::new('presentation')->onlyOnDetail(),
      BooleanField::new('IsAccepted'),
      AssociationField::new('acceptedBy')->hideOnForm(),
      DateField::new('createdAt')->onlyOnIndex(),
      DateField::new('updatedAt')->onlyOnIndex(),
    ];
  }

  public function configureActions(Actions $actions): Actions
  {
    return $actions
      ->add(Crud::PAGE_INDEX, Action::DETAIL)
      ->disable(Action::NEW);
  }
}
