<?php

namespace Stef\QuickCmsBundle\Controller;

use Stef\QuickCmsBundle\Entity\BaseTemplate;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}")
     */
    public function indexAction($name)
    {
        $product = new BaseTemplate();
        $product->setDisplayName('henk');
        $product->setTwig('henk');

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();
        exit;
    }
}
