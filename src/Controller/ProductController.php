<?php

namespace App\Controller;

use App\Entity\Product;
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
            'products' => $productRepo->findSomeProducts('category','Electronics',4),
        ]);
    }

    /**
     * @Route("/productModal/{id}", name="productModal")
     */
    public function loadModal($id,ProductRepository $productRepo)
    {
        $product = $productRepo->find($id);
        return $this->render('product/productModal.html.twig',['product'=>$product]);
    }
}
