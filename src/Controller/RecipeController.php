<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    #[Route('/recipes/{page<\d+>}', name: 'app_recipes')]
    public function recipes(RecipeRepository $recipeRepository, int $page = 1): Response
    {
        $queryBuilder = $recipeRepository->createQueryBuilderOrderedByNewest();
        $adapter = new QueryAdapter($queryBuilder);
        /** @var Recipe[]|Pagerfanta $pagerfanta */
        $pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage($adapter, $page, 4);

        return $this->render('recipes/list.html.twig', [
            'pager' => $pagerfanta,
        ]);
    }

    #[Route('/recipes/{slug}', name: 'app_recipes_show')]
    public function recipesShow(Recipe $recipe): Response
    {
        return $this->render('recipes/show.html.twig', [
            'recipe' => $recipe
        ]);
    }
}
