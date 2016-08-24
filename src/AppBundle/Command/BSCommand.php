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

class BSCommand extends ContainerAwareCommand
{
    public static $category = "";
    public static $gender = "";
    public static $age = "";

    protected function configure()
    {
        $this
            ->setName('backup:bs')
            ->setDescription('Download products from Bershka and Stradivarius')
            ->addArgument(
                'products',
                InputArgument::OPTIONAL,
                'How many products do you want to get?'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // STRADIVARIUS
        $links[] = [
            'link' => "https://www.stradivarius.com/itxrest/2/catalog/store/55009573/50331054/category/1317536/product?languageId=-21&appId=10",
            'category' => 'Rochii',
            'gender' => 'femeie',
            'age' => 'adult',
            'storeId' => 2
            ];

        $links[] = [
            'link' => "https://www.stradivarius.com/itxrest/2/catalog/store/55009573/50331054/category/1317535/product?languageId=-21&appId=1",
            'category' => 'Topuri',
            'gender' => 'femeie',
            'age' => 'adult',
            'storeId' => 2
            ];

        $links[] = [
            'link' => "https://www.stradivarius.com/itxrest/2/catalog/store/55009573/50331054/category/1317522/product?languageId=-21&appId=1",
            'category' => "Camasi",
            'gender' => 'femeie',
            'age' => 'adult',
            'storeId' => 2
        ];

        $links[] = [
            'link' => "https://www.stradivarius.com/itxrest/2/catalog/store/55009573/50331054/category/1317534/product?languageId=-21&appId=1",
            'category' => "Salopete",
            'gender' => 'femeie',
            'age' => 'adult',
            'storeId' => 2
        ];

        $links[] = [
            'link' => "https://www.stradivarius.com/itxrest/2/catalog/store/55009573/50331054/category/1317526/product?languageId=-21&appId=1",
            'category' => "Fuste",
            'gender' => 'femeie',
            'age' => 'adult',
            'storeId' => 2
        ];

        $links[] = [
            'link' => "https://www.stradivarius.com/itxrest/2/catalog/store/55009573/50331054/category/1317529/product?languageId=-21&appId=1",
            'category' => "Pantaloni",
            'gender' => 'femeie',
            'age' => 'adult',
            'storeId' => 2
        ];

        $links[] = [
            'link' => "https://www.stradivarius.com/itxrest/2/catalog/store/55009573/50331054/category/1317527/product?languageId=-21&appId=1",
            'category' => "Jeans",
            'gender' => 'femeie',
            'age' => 'adult',
            'storeId' => 2
        ];

        $links[] = [
            'link' => "https://www.stradivarius.com/itxrest/2/catalog/store/55009573/50331054/category/1317524/product?languageId=-21&appId=1",
            'category' => "Jachete",
            'gender' => 'femeie',
            'age' => 'adult',
            'storeId' => 2
        ];

        $links[] = [
            'link' => "https://www.stradivarius.com/itxrest/2/catalog/store/55009573/50331054/category/1641501/product?languageId=-21&appId=1",
            'category' => "Sacouri",
            'gender' => 'femeie',
            'age' => 'adult',
            'storeId' => 2
        ];


        // BERSHKA
        $links[] = [
            'link' => "https://www.bershka.com/itxrest/2/catalog/store/45109523/40259511/category/1010097516/product?languageId=-21&appId=1",
            'category' => "Topuri",
            'gender' => 'femeie',
            'age' => 'adult',
            'storeId' => 3
        ];

        $links[] = [
            'link' => "https://www.bershka.com/itxrest/2/catalog/store/45109523/40259511/category/1521713/product?languageId=-21&appId=1",
            'category' => "Jachete",
            'gender' => 'femeie',
            'age' => 'adult',
            'storeId' => 3
        ];

        $links[] = [
            'link' => "https://www.bershka.com/itxrest/2/catalog/store/45109523/40259511/category/1010032520/product?languageId=-21&appId=1",
            'category' => "Sacouri",
            'gender' => 'femeie',
            'age' => 'adult',
            'storeId' => 3
        ];

        $links[] = [
            'link' => "https://www.bershka.com/itxrest/2/catalog/store/45109523/40259511/category/1521717/product?languageId=-21&appId=1",
            'category' => "Rochii",
            'gender' => 'femeie',
            'age' => 'adult',
            'storeId' => 3
        ];

        $links[] = [
            'link' => "https://www.bershka.com/itxrest/2/catalog/store/45109523/40259511/category/1521714/product?languageId=-21&appId=1",
            'category' => "Jeans",
            'gender' => 'femeie',
            'age' => 'adult',
            'storeId' => 3
        ];

        $links[] = [
            'link' => "https://www.bershka.com/itxrest/2/catalog/store/45109523/40259511/category/1521715/product?languageId=-21&appId=1",
            'category' => "Pantaloni",
            'gender' => 'femeie',
            'age' => 'adult',
            'storeId' => 3
        ];

        $links[] = [
            'link' => "https://www.bershka.com/itxrest/2/catalog/store/45109523/40259511/category/1521718/product?languageId=-21&appId=1",
            'category' => "Camasi",
            'gender' => 'femeie',
            'age' => 'adult',
            'storeId' => 3
        ];

        $links[] = [
            'link' => "https://www.bershka.com/itxrest/2/catalog/store/45109523/40259511/category/1521721/product?languageId=-21&appId=1",
            'category' => "Fuste",
            'gender' => 'femeie',
            'age' => 'adult',
            'storeId' => 3
        ];

        $links[] = [
            'link' => "https://www.bershka.com/itxrest/2/catalog/store/45109523/40259511/category/1521719/product?languageId=-21&appId=1",
            'category' => "Pulovere",
            'gender' => 'femeie',
            'age' => 'adult',
            'storeId' => 3
        ];

        $links[] = [
            'link' => "https://www.bershka.com/itxrest/2/catalog/store/45109523/40259511/category/1521657/product?languageId=-21&appId=1",
            'category' => "Jachete",
            'gender' => 'barbat',
            'age' => 'adult',
            'storeId' => 3
        ];

        $links[] = [
            'link' => "https://www.bershka.com/itxrest/2/catalog/store/45109523/40259511/category/1521658/product?languageId=-21&appId=1",
            'category' => "Jeans",
            'gender' => 'barbat',
            'age' => 'adult',
            'storeId' => 3
        ];

        $links[] = [
            'link' => "https://www.bershka.com/itxrest/2/catalog/store/45109523/40259511/category/1521659/product?languageId=-21&appId=1",
            'category' => "Tricouri",
            'gender' => 'barbat',
            'age' => 'adult',
            'storeId' => 3
        ];

        $links[] = [
            'link' => "https://www.bershka.com/itxrest/2/catalog/store/45109523/40259511/category/1521665/product?languageId=-21&appId=1",
            'category' => "Camasi",
            'gender' => 'barbat',
            'age' => 'adult',
            'storeId' => 3
        ];

        $links[] = [
            'link' => "https://www.bershka.com/itxrest/2/catalog/store/45109523/40259511/category/1521662/product?languageId=-21&appId=1",
            'category' => "Pantaloni",
            'gender' => 'barbat',
            'age' => 'adult',
            'storeId' => 3
        ];

        $links[] = [
            'link' => "https://www.bershka.com/itxrest/2/catalog/store/45109523/40259511/category/1521661/product?languageId=-21&appId=1",
            'category' => "Pulovere",
            'gender' => 'barbat',
            'age' => 'adult',
            'storeId' => 3
        ];

        
        $i = 1;
        foreach ($links as $link) {
            $output->writeln("[" . $link['storeId'] . "] Backing up link " . $i . "/" . count($links) . "...");
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $link['link']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $json = curl_exec($ch);

            $json = json_decode($json, true);
            $this->getProducts($json, $link['category'], $link['storeId'], $link['gender'], $link['age']);
            $output->writeln("Done.");
            $i = $i + 1;
        }
    }

    public function getProducts($json, $category, $storeId, $gender, $age)
    {
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine')->getManager();
        /** @var ProductsRepository $productsRepository */
        $productsRepository = $em->getRepository('AppBundle:Products');

        foreach ($json['products'] as $product) {
            $name = $product['name'];

            if (is_null($name)) {
                continue;
            }
            foreach ($product['detail']['colors'] as $color) {
                $colorName = $color['name'];

                switch ($storeId) {
                    case 2:
                        $productLink = "http://www.stradivarius.com/ro/%C3%AEmbr%C4%83c%C4%83minte/rochii/rochie-c1317536p" . $product['id'] . ".html?colorId=" . $color['id'];
                        $imageLink = "http://static.e-stradivarius.net/5/photos2/" . $color['image']['url'] . "_1_1_3.jpg";
                        break;
                    case 3:
                        $productLink = "http://www.bershka.com/ro/femeie/femeie/tops/top-bretele-c1010097516p" . $product['id'] . ".html?colorId=251";
                        $imageLink = "http://static.bershka.net/4/photos2/" . $color['image']['url'] . "_1_1_3.jpg";
                        break;
                    default:
                        $productLink = "";
                        $imageLink = "";
                        break;
                }

                //$output->writeln($product['id']);
                foreach ($color['sizes'] as $size) {
                    $price = $size['price'];
                    $store = $em->getReference('AppBundle:Stores', $storeId);

                    /** @var Products $oldProduct */
                    $oldProduct = $productsRepository->findOneBy(
                        [
                            'name' => $name,
                            'picturePath' => $imageLink,
                            'store' => $store
                        ]
                    );

                    if (!is_null($oldProduct)) {
                        if ($oldProduct->getPrice() != (substr($price, 0, -2) . "." . substr($price, -2) . " LEI")) {
                            $oldProduct->setPrice(substr($price, 0, -2) . "." . substr($price, -2) . " LEI");
                            $em->persist($oldProduct);
                            $em->flush($oldProduct);
                        }
                        continue;
                    }

                    $newProduct = new Products();
                    $newProduct->setName($name)
                        ->setPicturePath($imageLink)
                        ->setPrice(substr($price, 0, -2) . "." . substr($price, -2) . " LEI")
                        ->setProductLink($productLink);

                    // Create new characteristic
                    $newCharacteristic = new Characteristics();
                    $newCharacteristic->setAge($age)
                        ->setCategory($category)
                        ->setGender($gender)
                        ->setColor(strtolower($colorName))
                        ->setPattern(0);
                    $em->persist($newCharacteristic);

                    $newProduct->setCharacteristic($newCharacteristic);
                    $newProduct->setStore($store);

                    $em->persist($newProduct);
                    $em->flush();
                    $em->clear();

                    break;
                }
            }

        }
    }
}