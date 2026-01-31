<?php

namespace App\Controller\Admin;

use App\Entity\Profile;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
/**/
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfileCrudController extends AbstractCrudController
{

    public function __construct(private UserPasswordHasherInterface $userPasswordHasher) {}

    public static function getEntityFqcn(): string
    {
        return Profile::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')
                ->hideOnForm(),
            TextField::new('firstName', 'First name'),
            TextField::new('lastName', 'Last name'),
            EmailField::new('email', 'E-mail'),
            TextField::new('password', 'Password')
                ->setFormType(PasswordType::class)
                ->hideOnIndex(),
            BooleanField::new('manage_images', 'Images'),
            BooleanField::new('manage_quiz', 'Quizzes'),
            BooleanField::new('manage_all', 'All'),
            TextField::new('createdBy', 'Created by')
                ->hideOnForm()
                ->hideOnIndex(),
            TextField::new('updatedBy', 'Updated by')
                ->hideOnForm()
                ->hideOnIndex(),
            DateTimeField::new('createdAt', 'Created at')->hideOnForm(),
            DateTimeField::new('updatedAt', 'Updated at')->hideOnForm(),
        ];
    }

    //
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function persistEntity(EntityManagerInterface $em, $entityInstance):void
    {
        if(!$entityInstance instanceof Profile)return;

        // encode the plain password
        $entityInstance->setPassword(
            $this->userPasswordHasher->hashPassword(
                $entityInstance,
                $entityInstance->getPassword()
            )
        );
        //
        $entityInstance->setCreatedBy($this->getUser()->getId());
        //
        parent::persistEntity($em, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if(!$entityInstance instanceof Profile) return;
        
        $entityInstance->setUpdatedBy($this->getUser()->getId());

        // encode the plain password
        $entityInstance->setPassword(
            $this->userPasswordHasher->hashPassword(
                $entityInstance,
                $entityInstance->getPassword()
            )
        );

        parent::persistEntity($em, $entityInstance);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityPermission('ROLE_SUPER_ADMIN')
        ;
    }
}
