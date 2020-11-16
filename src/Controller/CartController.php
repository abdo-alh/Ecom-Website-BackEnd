<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\Cart\CartService;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart_index")
     */
    public function index(CartService $cartService): Response
    {
        return $this->render('cart/cart.html.twig', [
            'items' => $cartService->getFullCartWithoutSerialize(),
            'total' => $cartService->getTotal()
        ]);
    }

    /**
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function add($id, CartService $cartService,ProductRepository $productRepository)
    {
        $cartService->add($id);
        $items = $cartService->getFullCart();

        return new JsonResponse($items,200,[],false);
    }

    /**
     * @Route("/cart/ajax", name="cart_ajax")
     */
    public function display(CartService $cartService)
    {
        $items = $cartService->getFullCart();

        return new JsonResponse($items,200,[],false);
    }

    /**
     * @Route("/cart/remove/{id}", name="cart_remove")
     */
    public function remove($id, CartService $cartService): Response
    {
        $cartService->remove($id);

        return $this->redirect('/cart');
    }
}
