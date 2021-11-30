<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Entity\Library;
use App\Entity\OfferBook;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(): Response
    {
        //return parent::index();
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        return $this->redirect($routeBuilder->setController(UserCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin console');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section("Page");
        yield MenuItem::linkToRoute('Website', 'fas fa-pager','app_hello');
        yield MenuItem::linkToLogout('Logout', '    fas fa-sign-out-alt');
        yield MenuItem::section("Users");
        yield MenuItem::linkToCrud("User",'fa fa-user',User::class);
        yield MenuItem::section("Books");
        yield MenuItem::linkToCrud("Book",'fas fa-book',Book::class);
        yield MenuItem::linkToCrud('Library','fas fa-book-reader',Library::class);
        yield MenuItem::linkToCrud('Offer Book','fas fa-book-medical',OfferBook::class);
    }
}
