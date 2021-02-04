<?php

namespace App\Controller;

use App\Service\Card\CardService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    /**
     * @Route("/panier", name="card_index")
     */
    public function index(CardService $cardService): Response
    {
        return $this->render('card/index.html.twig', [
            'items' => $cardService->getFullCard(),
            'total' => $cardService->getTotal(),
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="card_add")
     */
    public function add($id, CardService $cardService): Response
    {
        $cardService->add($id);

       return $this->redirectToRoute("card_index");
    }

    /**
     * @Route("/panier/remove/{id}", name="card_remove")
     */
    public function remove($id, CardService $cardService)
    {
        $cardService->remove($id);
        return $this->redirectToRoute("card_index");
    }

}
