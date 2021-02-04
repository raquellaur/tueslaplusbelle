<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\SearchProductFormType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/products/", name="product_index")
     * @param Request $request
     * @param ProductRepository $pr
     * @return Response
     */
    public function index(Request $request, ProductRepository $pr):Response
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty( $_GET['q'])) {
            $getSearch = $_GET['q'];
            $products = $pr->findLikeName($getSearch);
        } else {
            $products = $pr->findAll();
        }
        return $this->render('pages/product.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/products/{id}", name="product_category_show")
     * @param Category $category
     * @return Response
     */
    public function showProductCategory(Category $category):Response
    {
        $products = $category->getProducts();
         return $this->render('pages/product.html.twig', [
            'products' => $products,
        ]);
    }
}