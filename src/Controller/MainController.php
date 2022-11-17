<?php

namespace App\Controller;

use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function homepage(RecipeRepository $recipeRepository): Response
    {
        $latestRecipes = $recipeRepository->createQueryBuilderOrderedByNewest()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();

        return $this->render('main/homepage.html.twig', [
            'latestRecipes' => $latestRecipes,
        ]);
    }
}
