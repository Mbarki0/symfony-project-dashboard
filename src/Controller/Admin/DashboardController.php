<?php

namespace App\Controller\Admin;

use App\Entity\Profile;
use App\Entity\Patient;
use App\Entity\PatientFolder;
use App\Entity\Level;
use App\Entity\Quiz;
use App\Entity\Question;
use App\Entity\Image;
use App\Entity\ProfileQuizResult;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
/* */
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;

class DashboardController extends AbstractDashboardController
{

    public function __construct(private AdminUrlGenerator $adminUrlGenerator) {}

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        if (!$this->getUser())
            return $this->redirectToUrl('/login');
        elseif(!in_array('ROLE_ADMIN', $this->getUser()->getRoles(), true))
            return $this->redirectToUrl('/images');

        /* $url = $this->adminUrlGenerator
            ->setController(PatientCrudController::class)
            ->generateUrl();
        return $this->redirect($url); */
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle("<img src='images/logo.png' width='100%'>");
    }

    public function configureMenuItems(): iterable
    {
        $menu[] = MenuItem::linkToUrl('Home', 'fa fa-home', '/images');
        if($this->getUser()->isManageAll()) {
            $menu[] = MenuItem::section('User');
            $menu[] = MenuItem::linkToCrud('Profil', 'fas fa-arrow-circle-right', Profile::class);
        }
        $menu[] = MenuItem::section('entities');
        $menu[] = MenuItem::linkToCrud('Patient', 'fas fa-arrow-circle-right', Patient::class);
        $menu[] = MenuItem::linkToCrud('Patient folder','fas fa-arrow-circle-right', PatientFolder::class);
        $menu[] = MenuItem::linkToCrud("Image",'fas fa-arrow-circle-right', Image::class);

        $menu[] = MenuItem::section('quizzes');
        $menu[] = MenuItem::linkToCrud('Niveaux', 'fas fa-arrow-circle-right', Level::class);
        $menu[] = MenuItem::linkToCrud('Quizzes','fas fa-arrow-circle-right', Quiz::class);
        $menu[] = MenuItem::linkToCrud('Questions','fas fa-arrow-circle-right', Question::class);
        $menu[] = MenuItem::linkToCrud('Résultats','fas fa-arrow-circle-right', ProfileQuizResult::class);

        $menu[] = MenuItem::section('Paramètres');
        $menu[] = MenuItem::linkToUrl('My account', 'fas fa-user-edit', '/profile/'.$this->getUser()->getId());
        $menu[] = MenuItem::linkToLogout('Logout', 'fas fa-sign-out');
        return $menu;
    }

    public function configureAssets(): Assets
    {
        return parent::configureAssets()
            ->addWebPackEncoreEntry('admin');
    }
}
