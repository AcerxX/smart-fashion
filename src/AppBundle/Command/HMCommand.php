<?php

// src/AppBundle/Command/HMCommand.php
namespace AppBundle\Command;

use AppBundle\Entity\Characteristics;
use AppBundle\Entity\Products;
use AppBundle\Repository\ProductsRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

class HMCommand extends ContainerAwareCommand
{
    public static $category = "";
    public static $gender = "";
    public static $age = "";

    protected function configure()
    {
        $this
            ->setName('backup:hm')
            ->setDescription('Download products from H&M Store.')
            ->addArgument(
                'products',
                InputArgument::OPTIONAL,
                'How many products do you want to get?'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /*
         * Begin getting information from H&M
         */
        $numberOfProducts = $input->getArgument('products') != null ? $input->getArgument('products') : 5;

        $links = array();

        /* FEMEI */

        $linkLine = array();
        $linkLine['link'] = "http://www2.hm.com/ro_ro/femei/cumparaturi-sortate-dupa-produs/topuri.html?product-type=ladies_tops&sort=stock&offset=0&page-size=" . $numberOfProducts;
        $linkLine['category'] = "Topuri";
        $linkLine['age'] = "adult";
        $linkLine['gender'] = "femeie";

        $links[] = $linkLine;


        $linkLine = array();
        $linkLine['link'] = "http://www2.hm.com/ro_ro/femei/cumparaturi-sortate-dupa-produs/rochii.html?product-type=ladies_dresses&sort=stock&offset=0&page-size=" . $numberOfProducts;
        $linkLine['category'] = "Rochii";
        $linkLine['age'] = "adult";
        $linkLine['gender'] = "femeie";

        $links[] = $linkLine;


        $linkLine = array();
        $linkLine['link'] = "http://www2.hm.com/ro_ro/femei/cumparaturi-sortate-dupa-produs/fuste.html?product-type=ladies_skirts&sort=stock&offset=0&page-size=" . $numberOfProducts;
        $linkLine['category'] = "Fuste";
        $linkLine['age'] = "adult";
        $linkLine['gender'] = "femeie";

        $links[] = $linkLine;


        $linkLine = array();
        $linkLine['link'] = "http://www2.hm.com/ro_ro/femei/cumparaturi-sortate-dupa-produs/pantaloni.html?product-type=ladies_trousers&sort=stock&offset=0&page-size=" . $numberOfProducts;
        $linkLine['category'] = "Pantaloni";
        $linkLine['age'] = "adult";
        $linkLine['gender'] = "femeie";

        $links[] = $linkLine;


        $linkLine = array();
        $linkLine['link'] = "http://www2.hm.com/ro_ro/femei/cumparaturi-sortate-dupa-produs/trening.html?product-type=ladies_jumpsuits&sort=stock&offset=0&page-size=" . $numberOfProducts;
        $linkLine['category'] = "Salopete";
        $linkLine['age'] = "adult";
        $linkLine['gender'] = "femeie";

        $links[] = $linkLine;


        $linkLine = array();
        $linkLine['link'] = "http://www2.hm.com/ro_ro/femei/cumparaturi-sortate-dupa-produs/cardigan-si-pulovere/pulovere.html?product-type=ladies_cardigansjumpers_jumpers&sort=stock&offset=0&page-size=" . $numberOfProducts;
        $linkLine['category'] = "Pulovere";
        $linkLine['age'] = "adult";
        $linkLine['gender'] = "femeie";

        $links[] = $linkLine;


        $linkLine = array();
        $linkLine['link'] = "http://www2.hm.com/ro_ro/femei/cumparaturi-sortate-dupa-produs/camasi-si-bluze/camasi.html?product-type=ladies_shirtsblouses_shirts&sort=stock&offset=0&page-size=" . $numberOfProducts;
        $linkLine['category'] = "Camasi";
        $linkLine['age'] = "adult";
        $linkLine['gender'] = "femeie";

        $links[] = $linkLine;


        $linkLine = array();
        $linkLine['link'] = "http://www2.hm.com/ro_ro/femei/cumparaturi-sortate-dupa-produs/blazere-si-veste/blazere.html?product-type=ladies_blazerswaistcoats_blazers&sort=stock&offset=0&page-size=" . $numberOfProducts;
        $linkLine['category'] = "Sacouri";
        $linkLine['age'] = "adult";
        $linkLine['gender'] = "femeie";

        $links[] = $linkLine;


        /* BARBATI */

        $linkLine = array();
        $linkLine['link'] = "http://www2.hm.com/ro_ro/barbati/cumparaturi-sortate-dupa-produs/tricouri-si-maiouri/maneca-scurta.html?product-type=men_tshirtstanks_shortsleeve&sort=stock&offset=0&page-size=" . $numberOfProducts;
        $linkLine['category'] = "Tricouri";
        $linkLine['age'] = "adult";
        $linkLine['gender'] = "barbat";

        $links[] = $linkLine;


        $linkLine = array();
        $linkLine['link'] = "http://www2.hm.com/ro_ro/barbati/cumparaturi-sortate-dupa-produs/camasi.html?product-type=men_shirts&sort=stock&offset=0&page-size=" . $numberOfProducts;
        $linkLine['category'] = "Camasi";
        $linkLine['age'] = "adult";
        $linkLine['gender'] = "barbat";

        $links[] = $linkLine;


        $linkLine = array();
        $linkLine['link'] = "http://www2.hm.com/ro_ro/barbati/cumparaturi-sortate-dupa-produs/pantaloni.html?product-type=men_trousers&sort=stock&offset=0&page-size=" . $numberOfProducts;
        $linkLine['category'] = "Pantaloni";
        $linkLine['age'] = "adult";
        $linkLine['gender'] = "barbat";

        $links[] = $linkLine;


        $linkLine = array();
        $linkLine['link'] = "http://www2.hm.com/ro_ro/barbati/cumparaturi-sortate-dupa-produs/jachete-si-paltoane/jachete.html" . $numberOfProducts;
        $linkLine['category'] = "Jachete";
        $linkLine['age'] = "adult";
        $linkLine['gender'] = "barbat";

        $links[] = $linkLine;


        $linkLine = array();
        $linkLine['link'] = "http://www2.hm.com/ro_ro/barbati/cumparaturi-sortate-dupa-produs/jeans.html?product-type=men_jeans&sort=stock&offset=0&page-size=" . $numberOfProducts;
        $linkLine['category'] = "Jeans";
        $linkLine['age'] = "adult";
        $linkLine['gender'] = "barbat";

        $links[] = $linkLine;


        /* COPII - FETE */

        $linkLine = array();
        $linkLine['link'] = "http://www2.hm.com/ro_ro/copii/cumparaturi-sortate-dupa-produs/fete-15-10-ani/topuri-si-tricouri.html?product-type=kids_girl8y_topstshirts&sort=stock&offset=0&page-size=" . $numberOfProducts;
        $linkLine['category'] = "Tricouri";
        $linkLine['age'] = "copil";
        $linkLine['gender'] = "femeie";

        $links[] = $linkLine;


        $linkLine = array();
        $linkLine['link'] = "http://www2.hm.com/ro_ro/copii/cumparaturi-sortate-dupa-produs/fete-15-10-ani/pantaloni-si-colanti.html?product-type=kids_girl8y_trousersleggings&sort=stock&offset=0&page-size=" . $numberOfProducts;
        $linkLine['category'] = "Pantaloni";
        $linkLine['age'] = "copil";
        $linkLine['gender'] = "femeie";

        $links[] = $linkLine;


        $linkLine = array();
        $linkLine['link'] = "http://www2.hm.com/ro_ro/copii/cumparaturi-sortate-dupa-produs/fete-15-10-ani/rochii-si-fuste/rochii.html?product-type=kids_girl8y_dressesskirts_dresses&sort=stock&offset=0&page-size=" . $numberOfProducts;
        $linkLine['category'] = "Rochii";
        $linkLine['age'] = "copil";
        $linkLine['gender'] = "femeie";

        $links[] = $linkLine;


        /* COPII - BAIETI */

        $linkLine = array();
        $linkLine['link'] = "http://www2.hm.com/ro_ro/copii/cumparaturi-sortate-dupa-produs/baieti-15-10-ani/topuri-si-tricouri.html?product-type=kids_boy8y_topstshirts&sort=stock&offset=0&page-size=" . $numberOfProducts;
        $linkLine['category'] = "Tricouri";
        $linkLine['age'] = "copil";
        $linkLine['gender'] = "barbat";

        $links[] = $linkLine;


        $linkLine = array();
        $linkLine['link'] = "http://www2.hm.com/ro_ro/copii/cumparaturi-sortate-dupa-produs/baieti-15-10-ani/pantaloni.html?product-type=kids_boy8y_trousers&sort=stock&offset=0&page-size=" . $numberOfProducts;
        $linkLine['category'] = "Pantaloni";
        $linkLine['age'] = "copil";
        $linkLine['gender'] = "barbat";

        $links[] = $linkLine;


        $linkLine = array();
        $linkLine['link'] = "http://www2.hm.com/ro_ro/copii/cumparaturi-sortate-dupa-produs/baieti-15-10-ani/sorturi.html?product-type=kids_boy8y_shorts&sort=stock&offset=0&page-size=" . $numberOfProducts;
        $linkLine['category'] = "Pantaloni scurti";
        $linkLine['age'] = "copil";
        $linkLine['gender'] = "barbat";

        $links[] = $linkLine;

        $i = 0;


        foreach ($links as $link) {
            $i = $i + 1;
            $pid = pcntl_fork();

            if ( $pid == -1 ) {
                // Fork failed
                $output->writeln("NOT OK | PID = -1");
            } else if ( $pid ) {
                // We are the parent
                $output->writeln("Waiting for " . $pid . "..." . $i . "/" . count($links));
                $output->writeln("Done: " . $pid . ".");
            } else {
                // We are the child
                self::$category = $link['category'];
                self::$gender = $link['gender'];
                self::$age = $link['age'];

                $this->getProductsFromHM($link['link']);
                exit(0);
            }
        }

        exit(0);

    }

    public function getProductsFromHM($link)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $html = curl_exec($ch);

        // Get H&M whole page
        $crawler = new Crawler($html);

        // Get all products
        $products = $crawler->filter('.product-item');

        // For each product found on page we need to get the required datas
        $datas = $products->each(function ($crawler, $i) {
            // Get name and product link
            /** @var Crawler $nameCrawler */
            $nameCrawler = $crawler->filter('.product-item-headline a');
            $productLink = "http://www2.hm.com" . $nameCrawler->attr('href');
            $name = $nameCrawler->getNode(0)->textContent;

            // Get price
            /** @var Crawler $price */
            $priceCrawler = $crawler->filter('.product-item-price');
            $price = trim($priceCrawler->getNode(0)->textContent);

            /*
             * IMPROVEMENT!!!
             * Check if we already have the product to not add it multiple times.
             * Mark these products as updated.
             */
            /** @var EntityManager $em */
            $em = $this->getContainer()->get('doctrine')->getManager();
            /** @var ProductsRepository $productsRepository */
            $productsRepository = $em->getRepository('AppBundle:Products');
            $products = $productsRepository->findBy(
                array(
                    'name' => $name,
                    'price' => $price
                )
            );

            if (count($products) > 0) {
                return null;
            }

            // We need to access the product page to get images matching available colors
            // We will do this the same way we get the products
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $productLink);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $html = curl_exec($ch);

            $productPageCrawler = new Crawler($html);
            $colors = $productPageCrawler->filter('.product-colors .inputlist label input')->each(function ($crawler, $i) {
                $colorId = $crawler->attr('data-articlecode');
                $colorName = $crawler->attr('value');
                $colorLink = "http://www2.hm.com/ro_ro/productpage." . $colorId . ".html";

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $colorLink);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $html = curl_exec($ch);

                $productCrawler = new Crawler($html);

                // Get main image link
                $imageLink = $productCrawler->filter('.product-detail-main-image-image')->attr('src');

                return array(
                    'color' => $colorName,
                    'imageLink' => $imageLink
                );
            });


            /*
             * Insert product in DB
            */
            /** @var EntityManager $em */
            $em = $this->getContainer()->get('doctrine')->getManager();
            foreach ($colors as $color) {
                // Create new product
                $newProduct = new Products();
                $newProduct->setName($name)
                    ->setPicturePath($color['imageLink'])
                    ->setPrice($price)
                    ->setProductLink($productLink);

                // Create new characteristic
                $newCharacteristic = new Characteristics();
                $newCharacteristic->setAge(self::$age)
                    ->setCategory(self::$category)
                    ->setGender(self::$gender);

                // Separate color from pattern
                $words = explode('/', $color['color']);
                if (count($words) > 1) {
                    $newCharacteristic->setColor($words[0]);
                    $newCharacteristic->setPattern($words[1]);
                } else {
                    $newCharacteristic->setColor($words[0]);
                    $newCharacteristic->setPattern(0);
                }
                $em->persist($newCharacteristic);

                $newProduct->setCharacteristic($newCharacteristic);

                $HMStore = $em->getReference('AppBundle:Stores', '1');

                $newProduct->setStore($HMStore);
                $em->persist($newProduct);
            }
            $em->flush();


            /*
             * Return data for debug
             */
            return array(
                'link' => $productLink,
                'name' => $name,
                'colors' => $colors,
                'price' => $price
            );
        });

        return $datas;

    }
}