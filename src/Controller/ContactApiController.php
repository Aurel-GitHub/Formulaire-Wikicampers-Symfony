<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class ContactApiController extends Controller
{

    /**
     * php -S localhost:3000 -t public
     */

    /**
     * @Route("/api/contact", name="contact_api", methods={"GET"})
     */
    public function index(ContactRepository $repository)
    {
        return $this->json($repository->findAll(), 200, [], ['groups'=> 'contact:read']);
    }

    /**
     * @param ArticleRepository $repository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @Route("/api/contact/{id}", name="contact_api_id", methods={"GET"})
     */
    public function byId($id, ContactRepository $repository)
    {
        return $this->json($repository->find($id), 200, [], ['groups'=> 'contact:read']);
    }


    /**
     * @Route("api/contactdate", name="api_contact_get_by_date", methods={"GET"})
     */
    public function byDateDesc(ContactRepository $repository)
    {
        return $this->json($repository->findByDate(), 200, [], ['groups'=> 'contact:read']);
    }

    /**
     * @Route("api/contact", name="api_post", methods={"POST"})
     */
    public function post(Request $request, SerializerInterface $serializer, EntityManagerInterface $em)
    {

        $json = $request->getContent();

        $contact = $serializer->deserialize($json, Contact::class, 'json');

        $contact->setCreatedAt(new \DateTime());
        $em->persist($contact);
        $em->flush();

        return $this->json($contact, 201, [], ['groups' => 'contact:read']);
    }

    /**
     * @Route("api/contact/{id}", name="contact_update", methods={"PATCH"})
     */
    public function patch(SerializerInterface $serializer,$id, Request $request, ContactRepository $repository)
    {
        $data = $request->getContent();
        $json = $serializer->deserialize($data, Contact::class, 'json');

        $contact = $repository->updateQuery($id, $json);

        return $this->json($contact, '201', [], ['groups' => 'contact:read']);
    }

    /**
     * @Route("api/contact/{id}", name="contact_delete", methods={"DELETE"})
     */
    public function delete(Request $request,$id, ContactRepository $repo)
    {
        $data = $request->getContent();

        $obj = $repo->delete($id, $data);

        return new Response($obj,'202');
    }

}
