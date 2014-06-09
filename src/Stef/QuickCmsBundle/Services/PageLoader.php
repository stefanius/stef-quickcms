<?php

namespace Stef\QuickCmsBundle\Services;

use JMS\DiExtraBundle\Annotation\Service;

/**
 * @Service("stef.quickcms.pageloader")
 */
class PageLoader
{
    protected $em;

    /**
     * @DI\InjectParams({
     *     "em" = @DI\Inject("doctrine.orm.entity_manager")
     * })
     */
    public function __construct($em)
    {
        $this->em = $em;
    }

    /**
     * @param $route
     * @return mixed
     */
    public function findPageByRoute($route)
    {
        $page = $this->em->findOneByRoute($route);

        return $page;
    }
}