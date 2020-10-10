<?php

namespace Aurel\ContactBundle\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends Controller
{
    /**
     * @Route("/bundle", name="accueil")
     */
    public function homeBundle(ContactRepository $repository)
    {
        $data = $repository->findAll();

        return $this->render('views/accueil.html.twig', ['controller_name' => 'ContactController', 'contacts' => $data]);
    }

    /**
     * @Route("/bundle/formulaire", name="formContact")
     */


    public function createBundle(Request $request, EntityManagerInterface $manager, \Swift_Mailer $mailer)
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact->setCreatedAt(new \DateTime());
            $manager->persist($contact);
            $manager->flush();

            /**
             * Mail
             */
            $email = (new \Swift_Message('Donneé infos'))
                ->setFrom($form->get('mail')->getData())
                ->setTo('patxi.laduche@wikicampers.fr')
                ->setBody(
                    $this->renderView(
                        'views/email.html.twig',
                        [
                            'prenom' => $form->get('prenom')->getData(),
                            'nom' => $form->get('nom')->getData(),
                            'mail'=> $form->get('mail')->getData(),
                            'description' => $form->get('description')->getData()
                        ]),'text/html'
                );
            $mailer->send($email);


            /**
             * Mail de confirmation
             */
            $messageConfirmation = (new \Swift_Message('Donneé infos'))
                ->setFrom($form->get('mail')->getData())
                ->setTo($form->get('mail')->getData())
                ->setBody(
                    $this->renderView(
                        'views/confirmation.html.twig',
                        [
                            'prenom' => $form->get('prenom')->getData(),
                            'nom' => $form->get('nom')->getData(),
                            'mail'=> $form->get('mail')->getData(),
                            'description' => $form->get('description')->getData()
                        ]),'text/html'
                );
            $mailer->send($messageConfirmation);

            $this->addFlash('success', 'Votre mail à bien été envoyé');

            return $this->redirectToRoute('accueil');
        }

        return $this->render('views/formulaire.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @Route("/{id}", name="delete_contact", methods={"DELETE"})
     */
    public function delete(Request $request, Contact $contact): Response
    {
        if ($this->isCsrfTokenValid('delete' . $contact->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contact);
            $entityManager->flush();
            return $this->redirectToRoute('accueil');
        }
        return new Response($this->addFlash('danger', 'suppression confirmée'));
    }
}
