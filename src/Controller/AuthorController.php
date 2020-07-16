<?php


namespace App\Controller;


use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{

      /**
      * @Route("/authors", name="Authors")
       */
    public function AuthorsList(AuthorRepository $authorRepository)
    // Correspond à AuthorRepository = new $AutorRepository
    //je veux pouvoir utiliser les méthodes de l'ensemble de cette classe
    // Quand on veut une nouvelle instance de la class pour pouvoir utiliser les méthodes de cette classe
      //  Dès que l'on veut utiliser une classe
    {
        $authors = $authorRepository->findAll();
        // Je crée la variable $authors qui récupére les données (findAll) dans la méthode $authorRepository
        return $this->render('authors.html.twig', [
            'authors' => $authors
            // je récupère la vue dans 'authors.html.twig' grace à la méthode Render
            //Je crée la variable 'authors' qui contient tous les auteurs  ($authors) de ma bdd

        ]);
    }

    /**
     * @Route("/authors/{id}", name="author_show")
     */
    // Je crée ma route et j'indique la Wildcard
    public function authorShow(AuthorRepository $authorRepository, $id)
    {
        // je récupére les données de ma requête Author et l'ID et je crée une nouvelle méthode authorShow
        $author = $authorRepository->find($id);
        //Je c
        return $this->render('authorShow.html.twig',[
            'author' => $author ]);
    }
}