<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderFormType;
use App\Service\Cart\CartService;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CheckoutController extends AbstractController
{
    /**
     * @Route("/checkout", name="checkout")
     */
    public function index(CartService $cartService, Request $request, SessionInterface $session): Response
    {
        if (empty($cartService->getFullCart())) {
            $this->addFlash("info","Your Cart is Empty Please Add Some Products To Your Cart !");
            return $this->redirectToRoute("shop");
        }
        $order = new Order();
        $form = $this->createForm(OrderFormType::class, $order);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($order->getPaymentMethod() == "cod") {
                $order->setPaymentStatus("unpaid");
            } elseif ($order->getPaymentMethod() == "paypal") {
                $order->setPaymentStatus("paid");
            }
            $order->setOrderTotal($cartService->getTotal());
            $order->setReference('REF-' . strtoupper(str_shuffle("ABCDEFGHIGKLM")));
            $order->setDateOrder(new \DateTime('now'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();

            if ($order->getPaymentMethod() == "cod") {
                $session->set('panier', []);
                return $this->render('checkout/thankyou-page.html.twig', [
                    'order' => $order
                ]);
            } elseif ($order->getPaymentMethod() == "paypal") {
                return $this->redirectToRoute('paypal');
            }
        }
        return $this->render('checkout/checkout-page.html.twig', [
            'total' => $cartService->getTotal(),
            'subTotal' => $cartService->getSubTotal(),
            'shipPrice' => $cartService->getShipPrice(),
            'checkoutForm' => $form->createView()
        ]);
    }
}
