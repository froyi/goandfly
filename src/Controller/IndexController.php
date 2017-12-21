<?php
declare (strict_types=1);

namespace Project\Controller;

/**
 * Class IndexController
 * @package Project\Controller
 */
class IndexController extends DefaultController
{
    public function indexAction(): void
    {
        $this->showStandardPage('home');
    }
}