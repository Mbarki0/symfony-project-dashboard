<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
/**/
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use Doctrine\ORM\EntityManagerInterface;


class ImageCrudController extends AbstractCrudController
{

    public const BANQUE_BASE_PATH = 'upload/banque-dimages';
    public const BANQUE_UPLOAD_DIR = 'public/upload/banque-dimages';

    public static function getEntityFqcn(): string
    {
        return Image::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'Id')->hideOnForm(),
            TextField::new('title', 'Title'),
            ImageField::new('path', 'Image')
                ->setBasePath(self::BANQUE_BASE_PATH)
                ->setUploadDir(self::BANQUE_UPLOAD_DIR),
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
        if(!$entityInstance instanceof Image)return;

        // encode the plain password
        $entityInstance->setCreatedBy($this->getUser()->getId());
        //
        parent::persistEntity($em, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if(!$entityInstance instanceof Image) return;
        
        $entityInstance->setUpdatedBy($this->getUser()->getId());

        parent::persistEntity($em, $entityInstance);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityPermission('ROLE_IMAGES')
        ;
    }
}
