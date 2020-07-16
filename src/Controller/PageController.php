<?php


namespace App\Controller;


use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/home", name="accueil")
     */
    public function home(BookRepository $bookRepository, AuthorRepository $authorRepository)
    {
        // On veut récupérer une instance de la variable 'BookRepository $bookRespository'
        //J'isntancie dans la variable la class pour récupérer les valeurs requises

        // je crée ma route pour ma page d'accueil
        $book3 = $bookRepository->findBy([], ['id' =>'desc'], 3);
        //le premier Array permet de rechercher dans une colonne. Mais là on souhaite tous les livres.
        // le 2ème paramère est un critère de tri, ici deuis le bas.
        // Le 3ème détermine la limite de notre recherche ici les 3
        $authors = $authorRepository->findBy([], ['id' =>'desc'], 3);
        // Je crée ma recherche puis je lui donne une valeur
        return $this->render('home.html.twig', [
            // je crée la variable Twig 'book' et 'authors' que j'irai appeler dans mon fichier Twig Home.html.twig
            'book' => $book3,
            'authors' => $authors
        ]);
    }

}