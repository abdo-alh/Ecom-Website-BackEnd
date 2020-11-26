<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\SearchForm;
use App\Model\SearchData;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index(ProductRepository $productRepo): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepo->findSomeProducts('category', 'Electronics', 4),
        ]);
    }

    /**
     * @Route("/shop", name="shop")
     */
    public function shop(ProductRepository $productRepo, Request $request): Response
    {
        $data = new SearchData();
        $data->page = $request->get('page', 1);
        [$min,$max] = $productRepo->findMinMax($data);
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        return $this->render('product/shop-grid.html.twig', [
            'products' => $productRepo->findSearch($data),
            'form' => $form->createView(),
            'min' => $min,
            'max' => $max
        ]);
    }

    /**
     * @Route("/productModal/{id}", name="productModal")
     */
    public function loadModal($id, ProductRepository $productRepo)
    {
        $product = $productRepo->find($id);
        return $this->render('product/productModal.html.twig', ['product' => $product]);
    }
}
