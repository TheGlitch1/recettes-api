<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use App\Entity\Step;
use App\Entity\Unit;
use App\Entity\Image;
use App\Entity\Recipe;
use App\Entity\Source;
use App\Entity\Ingredient;
use App\Entity\IngredientGroup;
use App\Entity\RecipeHasSource;
use App\Entity\RecipeHasIngredient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin_dashboard_index')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Recettes Api')
            ->renderContentMaximized();
    }
  
    public function configureCrud(): Crud
    {
        $crud = parent::configureCrud()
                ->renderContentMaximized()
                ->showEntityActionsInlined();
        return $crud;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Recettes', 'fa fa-list-check', Recipe::class);
        
        yield MenuItem::section('Données');

        // yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class);
        yield MenuItem::linkToCrud('Sources', 'fa fa-share-from-square', Source::class);
        yield MenuItem::linkToCrud('Unités', 'fa fa-dice-one', Unit::class);
        yield MenuItem::linkToCrud('Ingrédients', 'fa fa-carrot', Ingredient::class);
        yield MenuItem::linkToCrud('Tags', 'fa fa-tags', Tag::class);

        yield MenuItem::section('Sous-données');

        yield MenuItem::linkToCrud('Etape', 'fa fa-forward-step', Step::class);
        yield MenuItem::linkToCrud('Photo', 'fa fa-photo', Image::class);
        yield MenuItem::linkToCrud('Groupes d\'ingrédients', 'fa fa-cubes-stacked', IngredientGroup::class);
        yield MenuItem::linkToCrud('Ingrédient de recette', 'fa fa-cubes-stacked', RecipeHasIngredient::class);
        yield MenuItem::linkToCrud('Source de recette', 'fa fa-tags', RecipeHasSource::class);
    }
}
