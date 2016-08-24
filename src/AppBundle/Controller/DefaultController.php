<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Characteristics;
use AppBundle\Entity\Products;
use AppBundle\Entity\Users;
use AppBundle\Repository\CharacteristicsRepository;
use AppBundle\Repository\ProductsRepository;
use AppBundle\Repository\UsersRepository;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\GeneratorBundle\Command\AutoComplete\EntitiesAutoCompleter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public static $category = "";
    public static $gender = "";
    public static $age = "";

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $error = $request->get('error');

        $userId = $this->get('session')->get('userId');
        if (!is_null($userId) && $userId != Users::USER_GUEST_ID) {
            return $this->redirectToRoute('mainPage');
        }

        return $this->render(
            'AppBundle::loginPage.html.twig',
            array(
                'errorMsg' => $error != null ? $error : ""
            )
        );
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction(Request $request)
    {
        $this->get('session')->set('userId', null);
        return $this->redirectToRoute('homepage');
    }


    public function index(Request $request)
    {
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

    public function loginCheckAction(Request $request)
    {
        $guest = $request->get('guest');
        if (!is_null($guest)) {
            $this->get('session')->set('userId', Users::USER_GUEST_ID);
        }

        $username = $request->get('username');
        $password = $request->get('password');


        if (!is_null($username)) {
            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();
            /** @var UsersRepository $usersRepository */
            $usersRepository = $em->getRepository('AppBundle:Users');
            /** @var Users $user */
            $user = $usersRepository->findOneBy(
                array(
                    'username' => $username,
                    'password' => $password
                )
            );

            if (is_null($user)) {
                return $this->redirectToRoute(
                    'homepage',
                    array(
                        'error' => 'Username-ul sau parola sunt gresite!'
                    )
                );
            }
            
            $this->get('session')->set('userId', $user->getId());
        }
        
        return $this->redirectToRoute(
            'mainPage',
            array(
            )
        );
    }

    public function registerAccountAction(Request $request)
    {
        $error = null;
        
        if ($request->getMethod() == 'POST') {
            $username = $request->get('username');
            $password = $request->get('password');
            $pwdConfirmation = $request->get('password_confirmation');
            $firstName = $request->get('first_name');
            $lastName = $request->get('last_name');
            $email = $request->get('email');
            $gender = $request->get('gender');
            $birthDate = $request->get('birth_date');

            if ($password != $pwdConfirmation) {
                $error = "Cele 2 parole nu sunt la fel!";
            } else {
                /** @var EntityManager $em */
                $em = $this->getDoctrine()->getManager();
                /** @var Users $user */
                $user = new Users();
                $user->setUsername($username)
                    ->setPassword($password)
                    ->setFirstName($firstName)
                    ->setLastName($lastName)
                    ->setEmail($email)
                    ->setGender(intval($gender))
                    ->setBirthDate(new \DateTime($birthDate));

                $em->persist($user);
                $em->flush();

                $this->get('session')->set('userId', $user->getId());

                return $this->redirectToRoute(
                    'mainPage',
                    array(
                        'userId' => $user->getId()
                    )
                );
            }
        }

        return $this->render(
            'AppBundle::registerAccount.html.twig',
            array(
                'errorMsg' => $error
            )
        );
    }

    public function testTwoAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var CharacteristicsRepository $characteristicsRepository */
        $characteristicsRepository = $em->getRepository('AppBundle:Characteristics');
        $allCharacteristics = $characteristicsRepository->findAll();

        /** @var Characteristics $characteristic */
        foreach ($allCharacteristics as $characteristic) {
            $words = explode('/', $characteristic->getColor());
            if (count($words) > 1) {
                $characteristic->setColor($words[0]);
                $characteristic->setPattern($words[1]);
                $em->persist($characteristic);
            } else {
                switch($words[0]) {
                    case "Black":
                        $characteristic->setColor("Negru");
                        break;
                    case "Orange":
                        $characteristic->setColor("Portocaliu");
                        break;
                    case "Dark green":
                        $characteristic->setColor("Verde-închis");
                        break;
                    case "Dark blue":
                        $characteristic->setColor("Albastru-închis");
                        break;
                    case "White":
                        $characteristic->setColor("Alb");
                        break;
                }
            }

        }
        $em->flush();

        return new JsonResponse("OK");
    }
}
