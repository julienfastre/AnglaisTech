<?php

namespace SOFFT\AnglaisBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of securityController
 *
 * @author julien
 */
class securityController extends Controller {
    
    public function loginAction() {
        return new Response("login");
    }
    
    public function login_checkAction() {
        return new Response("login_check");
    }
}

