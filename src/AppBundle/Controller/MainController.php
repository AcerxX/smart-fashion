<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FavoriteProducts;
use AppBundle\Entity\Products;
use AppBundle\Entity\Users;
use AppBundle\Repository\CharacteristicsRepository;
use AppBundle\Repository\FavoriteProductsRepository;
use AppBundle\Service\MainService;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    public function mainPageAction(Request $request)
    {
        $userId = $this->get('session')->get('userId');

        if (is_null($userId)) {
            return $this->redirectToRoute('homepage');
    }
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var Users $user */
        $user = $em->getReference('AppBundle:Users', $userId);
        $userFullName = $user->getFirstName() . " " . $user->getLastName();

        return $this->render(
            'AppBundle::mainPage.html.twig',
            array(
                'userFullName' => $userFullName,
                'isGuest' => $userId == Users::USER_GUEST_ID ? true : false
            )
        );
    }

    public function genderAgePageAction(Request $request)
    {
        $userId = $this->get('session')->get('userId');

        if (is_null($userId)) {
            return $this->redirectToRoute('homepage');
        }
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var Users $user */
        $user = $em->getReference('AppBundle:Users', $userId);
        $userFullName = $user->getFirstName() . " " . $user->getLastName();

        return $this->render(
            'AppBundle::genderAgePage.html.twig',
            array(
                'userId' => $userId,
                'userFullName' => $userFullName
            )
        );
    }

    public function categoryPageAction(Request $request)
    {
        $userId = $this->get('session')->get('userId');

        if (is_null($userId)) {
            return $this->redirectToRoute('homepage');
        }
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var Users $user */
        $user = $em->getReference('AppBundle:Users', $userId);
        $userFullName = $user->getFirstName() . " " . $user->getLastName();

        $gender = strtolower($request->get('gender'));
        $age = strtolower($request->get('age'));

        /** @var CharacteristicsRepository $characteristicsRepository */
        $characteristicsRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Characteristics');
        $categories = $characteristicsRepository->getAllCategories($gender, $age);

        return $this->render(
            'AppBundle::categoryPage.html.twig',
            array(
                'gender' => $gender,
                'age' => $age,
                'categories' => $categories,
                'userId' => $userId,
                'userFullName' => $userFullName,
            )
        );
    }
    
    public function colorsPageAction(Request $request)
    {
        $userId = $this->get('session')->get('userId');

        if (is_null($userId)) {
            return $this->redirectToRoute('homepage');
        }
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var Users $user */
        $user = $em->getReference('AppBundle:Users', $userId);
        $userFullName = $user->getFirstName() . " " . $user->getLastName();

        $category = $request->get('category');
        $age = $request->get('age');
        $gender = $request->get('gender');

        /** @var CharacteristicsRepository $characteristicsRepository */
        $characteristicsRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Characteristics');
        $colors = $characteristicsRepository->getAllColors($gender, $age, $category);

        $primaryColors = ['maro', 'bleumarin', 'denim', 'grena', 'ocru', 'albastru', 'negru', 'roșu', 'galben', 'alb', 'portocaliu', 'verde', 'mov', 'roz', 'gri', 'bej', 'turcoaz', 'corai'];

        foreach ($primaryColors as $key => $primaryColor) {
            $hasProducts = $characteristicsRepository->checkIfColorHasProducts($gender, $age, $category, $primaryColor);

            if ($hasProducts[1] < 1) {
                unset($primaryColors[$key]);
                continue;
            }

            foreach ($colors as $colorKey => $color) {
                if (strpos(strtolower($color['color']), $primaryColor) !== false || strtolower($color['color']) == $primaryColor) {
                    unset($colors[$colorKey]);
                }
            }
        }

        return $this->render(
            'AppBundle::colorsPage.html.twig',
            array(
                'gender' => $gender,
                'age' => $age,
                'category' => $category,
                'userId' => $userId,
                'userFullName' => $userFullName,
                'colors' => $colors,
                'primaryColors' => $primaryColors
            )
        );
    }

    public function resultsPageAction(Request $request)
    {
        $userId = $this->get('session')->get('userId');

        if (is_null($userId)) {
            return $this->redirectToRoute('homepage');
        }
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var Users $user */
        $user = $em->getReference('AppBundle:Users', $userId);
        $userFullName = $user->getFirstName() . " " . $user->getLastName();

        $category = $request->get('category');
        $age = $request->get('age');
        $gender = $request->get('gender');
        $colors = $request->get('colors');
        
        $sort = $request->get('sort') == null ? 0 : $request->get('sort');
        $store = $request->get('store') == null ? 0 : $request->get('store');
        $price = $request->get('price') == null ? 0 : $request->get('price');
        $maxPrice = $request->get('maxPrice');
        
        $filters = array(
            'category' => $category,
            'gender' => $gender,
            'age' => $age,
            'color' => $colors,
            'sort' => $sort,
            'store' => $store,
            'price' => $price,
            'maxPrice' => $maxPrice
        );

        $maxPrice = 0;
        /** @var MainService $mainService */
        $mainService = $this->get('app.mainService');
        $results = $mainService->getResultsForFilters($filters, $maxPrice);

        return $this->render(
            'AppBundle::resultsPageV2.html.twig',
            array(
                'gender' => $gender,
                'age' => $age,
                'category' => $category,
                'results' => $results,
                'userId' => $userId,
                'userFullName' => $userFullName,
                'colors' => $colors,
                'isNotGuest' => intval($userId) !== Users::USER_GUEST_ID,
                'numberOfProductsFound' => count($results),
                'selectedSortId' => $sort,
                'selectedStoreId' => $store,
                'selectedPriceId' => $price,
                'maxPrice' => $maxPrice
            )
        );
    }

    public function addToFavoritesAction(Request $request)
    {
        $userId = $this->get('session')->get('userId');
        if (is_null($userId)) {
            return $this->redirectToRoute('homepage');
        }

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        
        $productId = $request->get('productId');
        /** @var Products $product */
        $product = $em->find('AppBundle:Products', $productId);

        /** @var FavoriteProductsRepository $favRepo */
        $favRepo = $em->getRepository('AppBundle:FavoriteProducts');
        $favProd = $favRepo->findOneBy(
            [
                'name' => $product->getName(),
                'picturePath' => $product->getPicturePath(),
                'productLink' => $product->getProductLink(),
                'store' => $product->getStore(),
                'user' => $em->getReference('AppBundle:Users', $userId)
            ]
        );

        if (!is_null($favProd)) {
            return new JsonResponse("OK");
        }

        $favoriteProduct = new FavoriteProducts();
        $favoriteProduct->setName($product->getName())
            ->setPicturePath($product->getPicturePath())
            ->setProductLink($product->getProductLink())
            ->setStore($product->getStore())
            ->setUser($em->getReference('AppBundle:Users', $userId));

        $em->persist($favoriteProduct);
        $em->flush();

        return new JsonResponse("OK");
    }
    
    public function favoriteProductsAction(Request $request)
    {
        $userId = $this->get('session')->get('userId');

        if (is_null($userId)) {
            return $this->redirectToRoute('homepage');
        }
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var Users $user */
        $user = $em->getReference('AppBundle:Users', $userId);
        $userFullName = $user->getFirstName() . " " . $user->getLastName();

        /** @var MainService $mainService */
        $mainService = $this->get('app.mainService');
        $results = $mainService->getFavoriteProductsForUser($user);

        return $this->render(
            'AppBundle::favoriteProductsPage.html.twig',
            array(
                'results' => $results,
                'numberOfProductsFound' => count($results),
                'userFullName' => $userFullName
            )
        );
    }

    public function removeFromFavoritesAction(Request $request)
    {
        $userId = $this->get('session')->get('userId');

        if (is_null($userId)) {
            return $this->redirectToRoute('homepage');
        }

        $productId = $request->get('productId');

        /** @var MainService $mainService */
        $mainService = $this->get('app.mainService');
        $mainService->disableFavoriteProduct($productId);

        return $this->redirectToRoute('favoriteProducts');
    }
}
