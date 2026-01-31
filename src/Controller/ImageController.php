<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Image;
use Knp\Component\Pager\PaginatorInterface;

class ImageController extends AbstractController
{
    private $imageRepository;

    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    #[Route('/images', name: 'app_images')]
    public function index(Request $request, PaginatorInterface $paginator): Response
    {

        // searchBar form
        $searchForm = $this->createFormBuilder()
            ->add('title', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'search-input',
                    'placeholder' => 'Trouvez des images sur différents types de cellules du sang ...',
                    'size' => '100%'
                ]
            ])
            ->setMethod('GET')
            ->getForm();

        $searchForm->handleRequest($request);
        if($searchForm->isSubmitted() && $searchForm->isValid())
        {
            $title = $searchForm->getData()['title'];
            $images = $this->imageRepository->findByTitle($title);
        } else {
            $images = $this->imageRepository->findAll();
        }

        $images = $paginator->paginate(
            $images,
            $request->query->getInt('page', 1),
            40
        );

        return $this->render('images/index.html.twig', [
            'images' => $images,
            'searchForm' => $searchForm->createView()
        ]);
    }
}
