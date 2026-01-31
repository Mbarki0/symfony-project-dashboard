<?php

namespace App\Controller\Admin;

use App\Entity\ProfileQuizResult;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
//
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;

class ProfileQuizResultCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProfileQuizResult::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID'),
            AssociationField::new('profile', 'Profile'),
            AssociationField::new('quiz', 'Quiz'),
            TextField::new('result', 'Résultat')
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityPermission('ROLE_QUIZZES')
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ;
    }
}
