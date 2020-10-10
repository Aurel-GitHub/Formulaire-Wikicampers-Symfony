<?php


namespace Aurel\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends Controller
{
    /**
     * @Route("/accueil", name="accueil_home")
     */
    public function accueil()
    {
        $this->render('views/index.html.twig');
    }
}
