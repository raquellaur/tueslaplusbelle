<?php

namespace App\Controller;

use App\Repository\CardRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param CardRepository $cardRepository
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function index(CardRepository $cardRepository, ProductRepository $productRepository):Response
    {
        $bestsellers = $cardRepository->findBestSellers();
        $newProducts = $productRepository->findByDate();
        return $this->render('pages/index.html.twig', [
            'bestsellers' => $bestsellers,
            'newProducts' => $newProducts,
        ]);
    }


}