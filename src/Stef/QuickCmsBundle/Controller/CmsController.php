<?php

namespace Stef\QuickCmsBundle\Controller;

use Stef\QuickCmsBundle\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class CmsController extends Controller
{
    /**
     * @Route("/pages/add")
     * @Template()
     */
    public function addPageAction(Request $request)
    {
        $page = new Page();

        $form = $this->createFormBuilder($page)
            ->add('pagetitle', 'text', ['label' => 'Titel'])
            ->add('pagebody', 'text', ['label' => 'Tekst'])
            ->add('save', 'submit', ['label' => 'Opslaan'])
            ->getForm();

        return $this->render('StefQuickCmsBundle:Cms:addpage.html.twig', array(
            'form' => $form->createView(),
        ));

        return array();
    }
}
