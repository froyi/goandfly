<?php
declare (strict_types=1);

namespace Project\Controller;

use Project\Utilities\Tools;

/**
 * Class BackendController
 * @package Project\Controller
 */
class JsonController extends DefaultController
{
    public function filterReisenAction()
    {
        $tags = Tools::getValue('tagIds');

        echo json_encode(array('status' => 'error','tags'=> $tags));
    }
}