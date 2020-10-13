<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    public function findByDate()
    {
        return  $this->createQueryBuilder('c')
                        ->orderBy('c.created_at', 'DESC' )
                        ->setMaxResults(5)
                        ->getQuery()
                        ->getResult();
    }

    public function updateQuery($id, $data)
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->update('App:Contact', 'c')
            ->set('c.prenom', '?1')
            ->set('c.nom', '?2')
            ->set('c.description', '?3')
            ->set('c.mail', '?4')
            ->where('c.id = :id')
            ->setParameter(1, $data->getPrenom())
            ->setParameter(2, $data->getNom())
            ->setParameter(3, $data->getDescription())
            ->setParameter(4, $data->getMail())
            ->setParameter('id', $id);
        $queryBuilder->getQuery()->execute();

        /**
         * Affichage des changments
         */
        $queryBuilder = $this->createQueryBuilder('c')
            ->select('c.prenom', 'c.nom', 'c.mail', 'c.description')
            ->where('c.id = :id')
            ->setParameter('id', $id);
        return $queryBuilder->getQuery()->getResult();
    }


    public function delete($id)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->delete('App:Contact', 'c');
        $qb->where('c.id = :id');
        $qb->setParameter('id', $id);

        return $qb->getQuery()->execute();
    }


}
