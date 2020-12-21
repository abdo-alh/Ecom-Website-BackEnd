<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends AbstractController
{
    /**
     * @Route("/",name="home")
     */
    public function home(CategoryRepository $categoryRepository,ProductRepository $productRepo,Request $request){
        $id = $request->query->get('id');
        return $this->render('home/home.html.twig',[
            'categories'=>$categoryRepository->findAll(),
            'products'=>$productRepo->findDiscountProduct(),
            'id'=>$id
        ]);
    }
}