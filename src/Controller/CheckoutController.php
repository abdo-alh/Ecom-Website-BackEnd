<?php

namespace App\Controller;

use App\Service\Cart\CartService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CheckoutController extends AbstractController
{
    /**
     * @Route("/checkout", name="checkout")
     */
    public function index(CartService $cartService): Response
    {
        return $this->render('checkout/checkout-page.html.twig', [
            'total'=>$cartService->getTotal()
        ]);
    }
}
