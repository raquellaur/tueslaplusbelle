<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\Card\CardService;
use Doctrine\ORM\EntityManagerInterface;
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
    public function add($id, CardService $cardService, ProductRepository $productRepository): Response
    {
        $product = $productRepository->find($id);
        if(!$product) {
            throw $this->createNotFoundException("Le product $id n'existe pas et ne peut pas être ajoute!");
        }
        $cardService->add($id);
        $this->addFlash("success","Le produit a été bien ajouté");
        return $this->redirectToRoute("card_index");
    }

    /**
     * @Route("/panier/remove/{id}", name="card_remove")
     */
    public function remove($id, CardService $cardService, ProductRepository $productRepository)
    {
        $product = $productRepository->find($id);
        if(!$product) {
            throw $this->createNotFoundException("Le product $id n'existe pas et ne peut pas être supprime!");
        }
        $cardService->remove($id);
        $this->addFlash("danger","Le produit a été bien supprime");
        return $this->redirectToRoute("card_index");
    }

    /**
     * @Route("/panier/decrement/{id}", name="card_decrement")
     * @param $id
     * @param CardService $cardService
     */
    public function decrement($id, CardService $cardService, ProductRepository $productRepository)
    {
        $product = $productRepository->find($id);
        if(!$product) {
            throw $this->createNotFoundException("Le product $id n'existe pas et ne peut pas etre décrémenté!");
        }
        $cardService->decrement($id);
        $this->addFlash("danger","Le produit a été bien décrémenté");
        return $this->redirectToRoute("card_index");
    }

    /**
     * @Route("/panier/register", name="card_register")
     * @param CardService $cardService
     * @param EntityManagerInterface $em
     */
    public function registreCard(CardService $cardService, EntityManagerInterface $em)
    {
        //$card = $cardService->getFullCard();
        $cardService->removeAll();
        $this->addFlash("success","Merci beaucoup pour votre commande!");
        return $this->redirectToRoute("home");
    }

}
