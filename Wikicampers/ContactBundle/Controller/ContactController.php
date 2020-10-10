<?php


namespace Aurel\ContactBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactController extends Controller
{
    public function homeAction()
    {
//        return $this->render('WikicampersContactBundle:Default:index.html.twig');
        return $this->render('@WikicampersContact/Default/index.html.twig');

    }

    public function formAction()
    {
        return $this->render('@WikicampersContact/Default/index.html.twig');

    }

}
