<?php

namespace App\Service\Cart;

use App\Repository\ProductRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class CartService
{

    private $productRepository;
    private $session;

    public function __construct(ProductRepository $productRepository, SessionInterface $session)
    {
        $this->productRepository = $productRepository;
        $this->session = $session;
    }

    public function add(int $id)
    {

        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        $this->session->set('panier', $panier);
    }

    public function remove(int $id)
    {

        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $this->session->set('panier', $panier);
    }

    public function getFullCart()
    {

        $panier = $this->session->get('panier', []);

        $normalizer = new ObjectNormalizer();
        $encoder = new JsonEncoder();
        $serializer = new Serializer([$normalizer], [$encoder]);

        foreach ($panier as $id => $quantity) {
            $product = $serializer->serialize($this->productRepository->find($id), 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['category', 'subCategory','createdAt','location']]);
            $panierWithData[] = [
                'product' => $product,
                'quantity' => $quantity
            ];
        }

        if(empty($panierWithData)){
            return [];
        }

        return $panierWithData;
    }

    public function getFullCartWithoutSerialize()
    {

        $panier = $this->session->get('panier', []);

        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'product' => $this->productRepository->find($id),
                'quantity' => $quantity
            ];
        }

        if(empty($panierWithData)){
            return [];
        }

        return $panierWithData;
    }

    public function getTotal()
    {
        $total = 0;

        foreach ($this->getFullCartWithoutSerialize() as $value) {
            $total += $value['product']->getPrice() * $value['quantity'];
        }

        return $total;
    }
}
