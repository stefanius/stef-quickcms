<?php

namespace Stef\QuickCmsBundle\Controller;

use Stef\QuickCmsBundle\Entity\BaseTemplate;
use Stef\QuickCmsBundle\Entity\Page;
use Stef\QuickCmsBundle\Services\PageLoader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/{url}", requirements={"url" = ".+"})
     */
    public function indexAction($url)
    {
        $pageLoader = $this->getPageLoader();
        $page = $pageLoader->findPageByRoute($url);

        return $this->render(
            $page->getBasetemplate()->getTwig(),
            [
                'template' => $page->getTemplate()->getTwig(),
                'pagebody' => $page->getPagebody(),
                'page'     => $page
            ]
        );
    }

    /**
     * @return PageLoader
     */
    protected function getPageLoader()
    {
        return $this->get('stef.quickcms.pageloader');
    }
}
