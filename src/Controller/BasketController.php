<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Pizza;
use App\Entity\Article;
use App\Repository\BasketRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER')]
class BasketController extends AbstractController
{
    #[Route('/mon-panier', name: 'app_basket-display')]
    public function display(): Response
    {
        return $this->render('basket/display.html.twig');
    }


    #[Route('mon-panier/{id}/ajouter', name:'app_basket_addArticle')]
    public function addArticle(Pizza $pizza, BasketRepository $repository): Response
    {
        /** @var User $user */
        $user=$this->getUser();
        dd();
        $basket=$user->getBasket();

        $article=new Article();
        $article->setQuantity(1);
        $article->setBasket($basket);
        $article->setPizza($pizza);

        $basket->addArticle($article);
        $repository->add($basket, true);

        return $this->redirectToroute('app_basket_display');
    }
}