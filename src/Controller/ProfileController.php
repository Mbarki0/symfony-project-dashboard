<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Repository\ProfileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends AbstractController
{
    public function __construct(
        private ProfileRepository $profileRepository,
        private UserPasswordHasherInterface $userPasswordHasher,
        private EntityManagerInterface $em
    ) {}

    #[Route('/profile/{id}', name: 'app_Profile', defaults: ['id' => null])]
    public function edit($id, Request $request): Response
    {
        if(!$this->getUser())
            $this->redirectToRout('app_login');

        $profile = $this->profileRepository->find($id);
        $editForm = $this->createFormBuilder($profile)
            ->add('lastName', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'input form-control',
                    'id' => 'nom',
                ]
            ])
            ->add('firstName', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'input form-control',
                    'id' => 'prenom'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'input form-control',
                    'id' => 'email'
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'input form-control',
                    'id' => 'password'
                ]
            ])
            ->getForm();

        $editForm->handleRequest($request);
        if($editForm->isSubmitted() && $editForm->isValid())
        {
            $profile->setLastName($editForm->get('lastName',)->getData());
            $profile->setFirstName($editForm->get('firstName',)->getData());
            $profile->setEmail($editForm->get('email')->getData());
            $profile->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $profile,
                    $editForm->get('password')->getData()
                )
            );
            $this->em->flush();
        }

        return $this->render('profile/edit.html.twig', [
            'editForm' => $editForm->createView(),
        ]);
    }
}
