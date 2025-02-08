<?php

namespace App\Repository;

use App\Entity\SignUp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SignUp>
 */
class SignUpRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SignUp::class);
    }

    /**
     * Méthode pour trouver un utilisateur par son email.
     * Cette méthode est déjà gérée par `findOneBy` mais peut être utilisée si une logique spécifique est requise.
     */
    public function findOneByEmail(string $email): ?SignUp
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Exemple : Récupérer tous les utilisateurs qui contiennent une partie d'un nom.
     * Non nécessaire pour le login, mais utile dans d'autres cas.
     */
    public function findByPartialName(string $name): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.nom LIKE :name')
            ->setParameter('name', '%' . $name . '%')
            ->orderBy('s.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Supprimer un utilisateur par son email.
     * Exemple d'une opération CRUD personnalisée.
     */
    public function deleteByEmail(string $email): void
    {
        $user = $this->findOneBy(['email' => $email]);

        if ($user) {
            $this->_em->remove($user);
            $this->_em->flush();
        }
    }
}
