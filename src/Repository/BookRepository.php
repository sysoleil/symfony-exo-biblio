<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    // /**
    //  * @return Book[] Returns an array of Book objects
    //  */

// je veux créer une requête spécifique. Pour cela
// je créé une méthode que je nomme.

    public function FindByWordsInResume ($word)

    {
        // je viens définir la variable en statique

        // la méthode createQueryBuilder est issue de ServiceEntityRepository qui étend elle même une autre classe
        // qui contient la méthode "createQueryBuilder"

        //Je vais récupérer la méthode "createQueryBuilder" (constructeur de SQL) pour créer ma requête et
        // j'affecte un alias à ma table book ("b")
        // et je le mets ensuite dans une variable $queryBuilder
        $queryBuilder  = $this->createQueryBuilder('b');

        // je sélectionne tout ce qu'il y a dans ma table avec la méthode select()
        $query = $queryBuilder->select('b')

            //Je dois sécuriser le contenu de la demande utilisateur avant de faire la requête, pour éviter
            // notammement les injections SQL. Pour ça j'utilise un placeholder :word
            // "On ne fait jamais confiance à l'utilisateur"
            // je cherche dans la colonne résume de la table 'b'.
            ->where('b.resume like :word')

            // Pour sécuriser mon code j'utilise setParameter pour remplacer le placeholder par la vraie valeur
            ->setParameter('word','%'.$word.'%')

            // Je récupére la requête finale
            ->getQuery();

        // J'exécute ma requête et je la stocke dans une variable
        $books = $query->getResult();
        //dump($books); die;
        // Je retourne la variable
        return $books;
    }
}
