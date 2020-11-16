<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends AbstractController
{
    /**
     * @Route("/",name="home")
     */
    public function home(ProductRepository $productRepo,Request $request){
        $id = $request->query->get('id');
        return $this->render('home/home.html.twig',[
            'products'=>$productRepo->findSomeProducts('subCategory','Laptops',4),
            'id'=>$id
        ]);
    }
}