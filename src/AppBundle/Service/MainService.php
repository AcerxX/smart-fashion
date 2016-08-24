<?php

namespace AppBundle\Service;

use AppBundle\Entity\Characteristics;
use AppBundle\Entity\FavoriteProducts;
use AppBundle\Entity\GlobalConfig;
use AppBundle\Entity\Products;
use AppBundle\Entity\Users;
use AppBundle\Repository\CharacteristicsRepository;
use AppBundle\Repository\FavoriteProductsRepository;
use AppBundle\Repository\GlobalConfigRepository;
use AppBundle\Repository\ProductsRepository;
use AppBundle\Repository\TableRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\User\User;

class MainService
{
    /** @var  EntityManager */
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param $filters
     * @param $maxPrice
     * @return array
     */
    public function getResultsForFilters($filters, &$maxPrice)
    {
        $results = array();

        /** @var CharacteristicsRepository $characteristicsRepository */
        $characteristicsRepository = $this->em->getRepository('AppBundle:Characteristics');
        $characteristics = $characteristicsRepository->getCharacteristicsByFilter($filters);

        foreach ($characteristics as $characteristic) {
            $results[] = $this->formatResultFromCharacteristic($characteristic, $maxPrice);
        }

        return $results;
    }

    /**
     * @param Characteristics $characteristic
     * @param $maxPrice
     * @return array
     */
    private function formatResultFromCharacteristic($characteristic, &$maxPrice)
    {
        $product = $characteristic->getProduct();
        $name = $product->getName();

        if (empty($name)) {
            $name = $characteristic->getCategory() . " " .  $product->getStore()->getName();
        }

        $resultElement = array(
            'picture' => $product->getPicturePath(),
            'name' => $name,
            'store' => $product->getStore()->getName(),
            'price' => $product->getPrice(),
            'productLink' => $product->getProductLink(),
            'storeLink' => $product->getStore()->getStoreLink(),
            'storeImage' => $product->getStore()->getStoreImage(),
            'productId' => $product->getId()
        );

        if (floatval($product->getPrice()) > $maxPrice) {
            $maxPrice = floatval($product->getPrice());
        }

        return $resultElement;
    }

    public function getFavoriteProductsForUser(Users $user)
    {
        $results = [];
        /** @var FavoriteProductsRepository $favoriteProductsRepository */
        $favoriteProductsRepository = $this->em->getRepository('AppBundle:FavoriteProducts');
        /** @var ProductsRepository $productsRepository */
        $productsRepository = $this->em->getRepository('AppBundle:Products');

        /** @var array $favoriteProducts */
        $favoriteProducts = $favoriteProductsRepository->findBy(
            [
                'user' => $user,
                'status' => FavoriteProducts::STATUS_ENABLED
            ],
            [
                'store' => 'ASC'
            ]
        );

        /** @var FavoriteProducts $favoriteProduct */
        foreach ($favoriteProducts as $favoriteProduct) {
            $price = "Indisponibil";

            /** @var Products $product */
            $product = $productsRepository->findOneBy(
                [
                    'picturePath' => $favoriteProduct->getPicturePath(),
                    'productLink' => $favoriteProduct->getProductLink()
                ]
            );
            if (!is_null($product)) {
                $price = $product->getPrice();
            }

            $results[] = [
                'picture' => $favoriteProduct->getPicturePath(),
                'name' => $favoriteProduct->getName(),
                'store' => $favoriteProduct->getStore()->getName(),
                'price' => $price,
                'productLink' => $favoriteProduct->getProductLink(),
                'storeLink' => $favoriteProduct->getStore()->getStoreLink(),
                'storeImage' => $favoriteProduct->getStore()->getStoreImage(),
                'productId' => $favoriteProduct->getId()
            ];
        }

        return $results;
    }

    public function disableFavoriteProduct($productId)
    {
        /** @var FavoriteProducts $favoriteProduct */
        $favoriteProduct = $this->em->find('AppBundle:FavoriteProducts', $productId);

        $favoriteProduct->setStatus(FavoriteProducts::STATUS_DISABLED);
        $this->em->persist($favoriteProduct);
        $this->em->flush();
    }
}
