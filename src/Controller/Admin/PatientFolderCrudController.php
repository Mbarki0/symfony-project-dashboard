<?php

namespace App\Controller\Admin;

use App\Entity\PatientFolder;
use App\Entity\ImageFolder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
//
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use App\Form\ImageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class PatientFolderCrudController extends AbstractCrudController
{

    public const BANQUE_BASE_PATH = 'upload/banque-dimages';
    public const BANQUE_UPLOAD_DIR = 'public/upload/banque-dimages';

    public function __construct(private SluggerInterface $slugger) {}

    public static function getEntityFqcn(): string
    {
        return PatientFolder::class;
    }
    
    //
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    //
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')->hideOnForm(),
            AssociationField::new('patient', 'IP du patient'),
            BooleanField::new('LAN', 'Leucémie aigue de novo')->hideOnIndex(),
            ArrayField::new('LAS', 'Leucémie aigue secondaire')->hideOnIndex(),
            TextField::new('RC', 'Renseignements cliniques')->hideOnIndex(),
            TextField::new('hemogramme', 'Hémogramme')->hideOnIndex(),
            TextField::new('FS', 'Frottis sangiun')->hideOnIndex(),
            TextField::new('CC', 'Myélogramme de diagnostic (Code + conclusion)')->hideOnIndex(),
            ChoiceField::new('MPO', 'MPO')
                ->setChoices([
                    'Positive' => 'Positive',
                    'Négative' => 'Négative', 
                    'Non réalisée' => 'Non réalisée'
                ])
                ->hideOnIndex(),
            ArrayField::new('MP', 'Immunophénotypage (marqueurs positifs)')->hideOnIndex(),
            TextField::new('CI', 'Conclusion immunophénotypage')->hideOnIndex(),
            ChoiceField::new('cytospin', 'Cytospin')
                ->setChoices([
                    'CNS1' => 'CNS1',
                    'CNS2' => 'CNS2',
                    'CNS3' => 'CNS3',
                    'TPL-' => 'TPL-',
                    'TPL+' => 'TPL+'
                ])
                ->hideOnIndex(),
            TextField::new('TP', 'Taux de prothrombine')->hideOnIndex(),
            TextField::new('TCA', 'TCA')->hideOnIndex(),
            TextField::new('DD', 'D-Dimère')->hideOnIndex(),
            TextField::new('AEH', 'Autres examens de l\'hemostase')->hideOnIndex(),
            TextField::new('calcemie', 'Calcémie')->hideOnIndex(),
            TextField::new('creat', 'Créat')->hideOnIndex(),
            TextField::new('CRP', 'CRP')->hideOnIndex(),
            TextField::new('PCT', 'PCT')->hideOnIndex(),
            TextField::new('LDH', 'LDH')->hideOnIndex(),
            TextField::new('BB', 'BILD/BILT')->hideOnIndex(),
            TextField::new('CF', 'Cytogénétique (Caryotype, FISH)')->hideOnIndex(),
            TextField::new('BOM', 'BOM')->hideOnIndex(),
            TextField::new('AU', 'Acide urique')->hideOnIndex(),
            TextField::new('BM', 'Biologie moléculaire')->hideOnIndex(),
            TextField::new('DF', 'Diagnostique final')->hideOnIndex(),
            TextField::new('MCC', 'Myélogramme de suivi (Code + conclusion)')->hideOnIndex(),
            ChoiceField::new('corticosensibilite', 'Corticosensibilite')
                ->setChoices([
                    'Corticosensible' => 'Corticosensible',
                    'Corticorésistant' => 'Corticorésistant'
                ])
                ->hideOnIndex(),
            ChoiceField::new('evolution', 'Evolution')
                ->setChoices([
                    'Rémission complète' => 'Rémission complète',
                    'Rechute' => 'Rechute',
                    'Résistance' => 'Résistance'
                ])
                ->hideOnIndex(),
            CollectionField::new('images', 'Images')
                ->setEntryType(ImageType::class)
                ->onlyOnForms()
                ->setFormTypeOption('mapped', false),
            CollectionField::new('imageFolders', 'Images')
                ->onlyOnDetail()
                ->setTemplatePath('imageFolder.html.twig'),
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
    public function persistEntity(EntityManagerInterface $em, $entityInstance):void
    {
        if(!$entityInstance instanceof PatientFolder) 
            return;
        //
        $entityInstance->setCreatedBy($this->getUser()->getId());
        //
        $files = parent::getContext()->getRequest()->files;
        //
        parent::persistEntity($em, $entityInstance);
        //

        if(!sizeof($files)) return;
        $images = $files->get('PatientFolder')['images'];
        //
        foreach($images as $image)
        {
            $file = $image['path'];
            $fileName = uniqid().'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('upload_directory'),
                $fileName
            );
            $imageFolder = new ImageFolder();
            $imageFolder->setPath($fileName);
            $imageFolder->setPatientFolder($entityInstance);
            $em->persist($imageFolder);
        }
        $em->flush();
    }

    //
    public function updateEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if(!$entityInstance instanceof PatientFolder) return;
        //
        $entityInstance->setUpdatedBy($this->getUser()->getId());
        //
        $files = parent::getContext()->getRequest()->files;
        //
        parent::persistEntity($em, $entityInstance);
        //
        if(!sizeof($files)) return;
        $images = $files->get('PatientFolder')['images'];
        //
        foreach($images as $image)
        {
            $file = $image['path'];
            $fileName = uniqid().'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('upload_directory'),
                $fileName
            );
            $imageFolder = new ImageFolder();
            $imageFolder->setPath($fileName);
            $imageFolder->setPatientFolder($entityInstance);
            $em->persist($imageFolder);
        }
        $em->flush();
    }

    //
    public function deleteEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if(!$entityInstance instanceof PatientFolder) return;
        //
        foreach($entityInstance->getImageFolders() as $imageFolder) {
            $em->remove($imageFolder);
        }
        parent::deleteEntity($em, $entityInstance);
    }

    //
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityPermission('ROLE_PATIENTS')
        ;
    }
}
