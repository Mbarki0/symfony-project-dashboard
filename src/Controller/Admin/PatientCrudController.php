<?php

namespace App\Controller\Admin;

use App\Entity\Patient;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
/**/
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PatientCrudController extends AbstractCrudController
{

    public function __construct(private UserPasswordHasherInterface $userPasswordHasher) {}

    public static function getEntityFqcn(): string
    {
        return Patient::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')
                ->hideOnForm()
                ->hideOnIndex(),
            TextField::new('ip', 'IP'),
            TextField::new('firstName', 'First name'),
            TextField::new('lastName', 'Last name'),
            ChoiceField::new('gender', 'Gender')
                ->setChoices([
                    'Male' => 'Male',
                    'Female' => 'Female', 
                    'Other' => 'Other'
                ]),
            DateField::new('birthDate', 'Date de naissance'),
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
        if(!$entityInstance instanceof Patient)return;

        // encode the plain password
        $entityInstance->setCreatedBy($this->getUser()->getId());
        //
        parent::persistEntity($em, $entityInstance);
    }
    
    public function updateEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if(!$entityInstance instanceof Patient) return;
        
        $entityInstance->setUpdatedBy($this->getUser()->getId());

        parent::persistEntity($em, $entityInstance);
    }

    public function deleteEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if(!$entityInstance instanceof Patient) return;
        //
        foreach($entityInstance->getPatientFolders() as $patientFolder) {
            $em->remove($patientFolder);
        }
        parent::deleteEntity($em, $entityInstance);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityPermission('ROLE_PATIENTS')
        ;
    }
}
