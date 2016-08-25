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

class MangoCommand extends ContainerAwareCommand
{
    public static $category = "";
    public static $gender = "";
    public static $age = "";

    protected function configure()
    {
        $this
            ->setName('backup:mango')
            ->setDescription('Download products from Bershka, Stradivarius and Mango')
            ->addArgument(
                'products',
                InputArgument::OPTIONAL,
                'How many products do you want to get?'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $links[] = [
            'link' => "http://shop.mango.com/services/productlist/products/RO/she/sections_she_sibe_rb_promo.prendas/?idSubSection=vestidosprendas&menu=familia;32&salesPeriod=true",
            'category' => "Rochii",
            'gender' => 'femeie',
            'age' => 'adult',
            'storeId' => 4
        ];

        $links[] = [
            'link' => "http://shop.mango.com/services/productlist/products/RO/she/sections_she_sibe_rb_promo.prendas/?idSubSection=monos&menu=familia;34&salesPeriod=true",
            'category' => "Salopete",
            'gender' => 'femeie',
            'age' => 'adult',
            'storeId' => 4
        ];

        $links[] = [
            'link' => "http://shop.mango.com/services/productlist/products/RO/she/sections_she_sibe_rb_promo.prendas/?idSubSection=blusas&menu=familia;14&salesPeriod=true",
            'category' => "Camasi",
            'gender' => 'femeie',
            'age' => 'adult',
            'storeId' => 4
        ];

        $links[] = [
            'link' => "http://shop.mango.com/services/productlist/products/RO/she/sections_she_sibe_rb_promo.prendas/?idSubSection=chaquetas&menu=familia;4,304&salesPeriod=true",
            'category' => "Jachete",
            'gender' => 'femeie',
            'age' => 'adult',
            'storeId' => 4
        ];

        $links[] = [
            'link' => "http://shop.mango.com/services/productlist/products/RO/she/sections_she_sibe_rb_promo.prendas/?idSubSection=pantalones&menu=familia;26,326&salesPeriod=true",
            'category' => "Pantaloni",
            'gender' => 'femeie',
            'age' => 'adult',
            'storeId' => 4
        ];

        $links[] = [
            'link' => "http://shop.mango.com/services/productlist/products/RO/she/sections_she_sibe_rb_promo.prendas/?idSubSection=tejanos&menu=familia;28&salesPeriod=true",
            'category' => "Jeans",
            'gender' => 'femeie',
            'age' => 'adult',
            'storeId' => 4
        ];

        $links[] = [
            'link' => "http://shop.mango.com/services/productlist/products/RO/she/sections_she_sibe_rb_promo.prendas/?idSubSection=faldas&menu=familia;20&salesPeriod=true",
            'category' => "Fuste",
            'gender' => 'femeie',
            'age' => 'adult',
            'storeId' => 4
        ];

        $links[] = [
            'link' => "http://shop.mango.com/services/productlist/products/RO/she/sections_she_sibe_rb_promo.prendas/?idSubSection=tops&menu=familia;18,318&salesPeriod=true",
            'category' => "Topuri",
            'gender' => 'femeie',
            'age' => 'adult',
            'storeId' => 4
        ];


        $links[] = [
            'link' => "http://shop.mango.com/services/productlist/products/RO/he/sections_he_sibe_rb_promo.prendas_he/?idSubSection=camisas_he&menu=familia;120&salesPeriod=true",
            'category' => "Camasi",
            'gender' => 'barbat',
            'age' => 'adult',
            'storeId' => 4
        ];

        $links[] = [
            'link' => "http://shop.mango.com/services/productlist/products/RO/he/sections_he_sibe_rb_promo.prendas_he/?idSubSection=cardigans_he&menu=familia;110&salesPeriod=true",
            'category' => "Pulovere",
            'gender' => 'barbat',
            'age' => 'adult',
            'storeId' => 4
        ];

        $links[] = [
            'link' => "http://shop.mango.com/services/productlist/products/RO/he/sections_he_sibe_rb_promo.prendas_he/?idSubSection=pantalones_he&menu=familia;131&salesPeriod=true",
            'category' => "Pantaloni",
            'gender' => 'barbat',
            'age' => 'adult',
            'storeId' => 4
        ];

        $links[] = [
            'link' => "http://shop.mango.com/services/productlist/products/RO/he/sections_he_sibe_rb_promo.prendas_he/?idSubSection=tejanos_he&menu=familia;130&salesPeriod=true",
            'category' => "Jeans",
            'gender' => 'barbat',
            'age' => 'adult',
            'storeId' => 4
        ];

        $links[] = [
            'link' => "http://shop.mango.com/services/productlist/products/RO/he/sections_he_sibe_rb_promo.prendas_he/?idSubSection=camisetas_he&menu=familia;115&salesPeriod=true",
            'category' => "Tricouri",
            'gender' => 'barbat',
            'age' => 'adult',
            'storeId' => 4
        ];

        $links[] = [
            'link' => "http://shop.mango.com/services/productlist/products/RO/he/sections_he_sibe_rb_promo.prendas_he/?idSubSection=chaquetas_he&menu=familia;109&salesPeriod=true",
            'category' => "Jachete",
            'gender' => 'barbat',
            'age' => 'adult',
            'storeId' => 4
        ];

        $links[] = [
            'link' => "http://shop.mango.com/services/productlist/products/RO/kids/sections_kidsA_rb_promo.prendas_kidsA/?idSubSection=vestidos&menu=familia;201&salesPeriod=true",
            'category' => "Rochii",
            'gender' => 'femeie',
            'age' => 'copil',
            'storeId' => 4
        ];

        $links[] = [
            'link' => "http://shop.mango.com/services/productlist/products/RO/kids/sections_kidsA_rb_promo.prendas_kidsA/?idSubSection=camisetas&menu=familia;207&salesPeriod=true",
            'category' => "Tricouri",
            'gender' => 'femeie',
            'age' => 'copil',
            'storeId' => 4
        ];

        $links[] = [
            'link' => "http://shop.mango.com/services/productlist/products/RO/kids/sections_kidsA_rb_promo.prendas_kidsA/?idSubSection=camisas&menu=familia;206&salesPeriod=true",
            'category' => "Camasi",
            'gender' => 'femeie',
            'age' => 'copil',
            'storeId' => 4
        ];

        $links[] = [
            'link' => "http://shop.mango.com/services/productlist/products/RO/kids/sections_kidsA_rb_promo.prendas_kidsA/?idSubSection=jerseys&menu=familia;204&salesPeriod=true",
            'category' => "Pulovere",
            'gender' => 'femeie',
            'age' => 'copil',
            'storeId' => 4
        ];

        $links[] = [
            'link' => "http://shop.mango.com/services/productlist/products/RO/kids/sections_kidsA_rb_promo.prendas_kidsA/?idSubSection=chaquetas&menu=familia;203&salesPeriod=true",
            'category' => "Jachete",
            'gender' => 'femeie',
            'age' => 'copil',
            'storeId' => 4
        ];

        $links[] = [
            'link' => "http://shop.mango.com/services/productlist/products/RO/kids/sections_kidsA_rb_promo.prendas_kidsA/?idSubSection=pantalones&menu=familia;208&salesPeriod=true",
            'category' => "Pantaloni",
            'gender' => 'femeie',
            'age' => 'copil',
            'storeId' => 4
        ];

        $links[] = [
            'link' => "http://shop.mango.com/services/productlist/products/RO/kids/sections_kidsA_rb_promo.prendas_kidsA/?idSubSection=tejanos&menu=familia;209&salesPeriod=true",
            'category' => "Blugi",
            'gender' => 'femeie',
            'age' => 'copil',
            'storeId' => 4
        ];

        $links[] = [
            'link' => "http://shop.mango.com/services/productlist/products/RO/kids/sections_kidsA_rb_promo.prendas_kidsA/?idSubSection=faldas&menu=familia;217&salesPeriod=true",
            'category' => "Fuste",
            'gender' => 'femeie',
            'age' => 'copil',
            'storeId' => 4
        ];


        $links[] = [
            'link' => "http://shop.mango.com/services/productlist/products/RO/kids/sections_kidsO_rb_promo.prendas_kidsO/?idSubSection=camisas_O&menu=familia;253&salesPeriod=true",
            'category' => "Camasi",
            'gender' => 'barbat',
            'age' => 'copil',
            'storeId' => 4
        ];

        $links[] = [
            'link' => "http://shop.mango.com/services/productlist/products/RO/kids/sections_kidsO_rb_promo.prendas_kidsO/?idSubSection=camisetas_O&menu=familia;254&salesPeriod=true",
            'category' => "Tricouri",
            'gender' => 'barbat',
            'age' => 'copil',
            'storeId' => 4
        ];

        $links[] = [
            'link' => "http://shop.mango.com/services/productlist/products/RO/kids/sections_kidsO_rb_promo.prendas_kidsO/?idSubSection=jerseys_O&menu=familia;252&salesPeriod=true",
            'category' => "Pulovere",
            'gender' => 'barbat',
            'age' => 'copil',
            'storeId' => 4
        ];

        $links[] = [
            'link' => "http://shop.mango.com/services/productlist/products/RO/kids/sections_kidsO_rb_promo.prendas_kidsO/?idSubSection=chaquetas_O&menu=familia;251&salesPeriod=true",
            'category' => "Jachete",
            'gender' => 'barbat',
            'age' => 'copil',
            'storeId' => 4
        ];

        $links[] = [
            'link' => "http://shop.mango.com/services/productlist/products/RO/kids/sections_kidsO_rb_promo.prendas_kidsO/?idSubSection=pantalones_O&menu=familia;257&salesPeriod=true",
            'category' => "Pantaloni",
            'gender' => 'barbat',
            'age' => 'copil',
            'storeId' => 4
        ];

        $links[] = [
            'link' => "http://shop.mango.com/services/productlist/products/RO/kids/sections_kidsO_rb_promo.prendas_kidsO/?idSubSection=tejanos_O&menu=familia;258&salesPeriod=true",
            'category' => "Jeans",
            'gender' => 'barbat',
            'age' => 'copil',
            'storeId' => 4
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

        foreach ($json['groups']['0']['garments'] as $garment) {
            foreach ($garment['colors'] as $color) {

                // SEARCH IF THERE IS ANY PRODUCT TO BE UPDATED
                $oldProduct = $productsRepository->findOneBy(
                    [
                        'name' => $garment['shortDescription'],
                        'picturePath' => $color['images']['0']['img1Src'],
                        'store' => $em->getReference('AppBundle:Stores', $storeId)
                    ]
                );

                if (!is_null($oldProduct)) {
                    if ($oldProduct->getPrice() != $garment['price']['salePrice']) {
                        $oldProduct->setPrice($garment['price']['salePrice']);
                        $em->persist($oldProduct);
                        $em->flush($oldProduct);
                    }

                    continue;
                }

                // IF NONE FOUND ADD A NEW PRODUCT
                $product = new Products();
                $product->setName($garment['shortDescription'])
                    ->setPrice($garment['price']['salePrice'])
                    ->setPicturePath($color['images']['0']['img1Src'])
                    ->setProductLink($color['linkAnchor'])
                    ->setStore($em->getReference('AppBundle:Stores', $storeId));

                $characteristic = new Characteristics();
                $characteristic->setAge($age)
                    ->setCategory($category)
                    ->setGender($gender)
                    ->setColor($color['label'])
                    ->setPattern('0');
                $em->persist($characteristic);

                $product->setCharacteristic($characteristic);

                $em->persist($product);
                $em->flush();
                $em->clear();
            }
        }
    }
}