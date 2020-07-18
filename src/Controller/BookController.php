<?php


namespace App\Controller;


use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Response;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    /**
     * @Route("/book/", name="book")
     */
    public function book (BookRepository $bookRepository)
    {
        $books = $bookRepository->findAll();
        Return $this->render('book.html.twig',[
           'books' =>$books ]);
    }

    /**
     * @Route("/book/{id}", name="book_Show")
     */
    public function bookShow(BookRepository $bookRepository, $id)
    {
        $book = $bookRepository->find($id);
        return $this->render('bookShow.html.twig',[
            'book' =>$book ]);
    }

    /**
     * @Route("/books/{genre}", name="book_genre")
     */
    public function genre(BookRepository $bookRepository, $genre)
    {
        $books = $bookRepository->findBy(["genre"=> $genre]);
            return $this->render('genre.html.twig', [
               'books' =>$books]);
    }
    /**
     * @Route("/books/search/resume", name="Book_Search_resume")
     */
    public function BooksSearchByResume(BookRepository $bookRepository, Request $request)
    {//J'instancie la class BookRepository dans la variable $bookRepository ça s'appelle l'AutoWire
        //idem pour Request
        //permet de récupérer tout ce que contient la class request
        // type int pour integer

        // Je récupére la valeur du paramétre dans l'Url
        // tapé dans le formulaire de "recherche". Je le met dans une classe
       $word = $request -> query->get('search');

        // J'initialise une variable $books qui contiendra un Array vide,
        // Ainsi je n'aurai pas d'erreur si je n'ai pas de parametre d'url de recherche
        // et que donc ma méthode '$bookRepository'ne sera pas appelée
        $books =[];

        //si mon utilisateur fait une recherche (Le paramètre sera dans l'Url)
        if (!empty($word)) {
            // je crée la requête select pour trouver dans la bdd $bookRepository les livres contenant
            //le paramètre saisi par l'utilisateur
            $books = $bookRepository ->FindByWordsInResume($word);
        }
        // j'appelle mon fichier twig avec les livres trouvés en BDD
        return $this->render('search.html.twig', [
            'books' => $books
        ]);
    }
    //Je crée la Route qu'il faudra mettre dans l'Url. Attention à la nomination pour éviter un conflit de route
    /**
     * @Route("/books_new", name="books_new")
     */
     public function books_new(EntityManagerInterface $entityManager)
     {
        //J'instancie la class EntityManagerInterface dans la variable $entityManager
         // les entités font le lien avec les tables
         // donc pour créer un enregistrement dans ma table book
         // je créé une nouvelle instance de l'entité Book
         $book = new Book();
        // Je crée un nouveau livre et je le mets dans une variable
         // j'indique les valeurs à ajouter dans les colonnes en utilisant les setters
         // pour 'hydrater' les données
         $book-> setTitle ("Les misérables");
         $book-> setGenre ("classique");
         $book-> setNbPages (567);
         $book-> setResume ('il était une fois Jean Valjean');


         $entityManager->persist($book);
         //la méthode persist permet de dire de tout prendre en mémoire
         $entityManager->flush();
         // puis je "valide" l'enregistrement avec la méthode flush()
     }
    /**
     * @Route("/books_insert", name="books_insert")
     */
     public function books_insert(BookRepository $bookRepository, EntityManagerInterface $entityManager)
         //j'instancie la class bookrepository dans la variable $bookRepository ainsi que pour EntityManagerInterface
     {
         $book = $bookRepository ->find(2);
        //j'appelle le livre dans le repository book ayant l'Id 2
         $book->setTitle('Candide');
         //l'entité est hydratée par la nouvelle donnée
         $entityManager->persist($book);
         // la méthode persist indique de récupérer la variable book modifiée et d'insérer
         $entityManager->flush();
         // la méthode 'flush' enregistre la modification
         // puis j'éxécute l'URL et je vais raffraichir ma DBB
     }
     //Je crée une nouvelle route pour instancier un nouveau bouquin

    /**
     * @Route ("/books_delete", name="books_delete")
     */
     public function books_delete(BookRepository $bookRepository, EntityManagerInterface $entityManager)
     {
         // je demande à symfony d'instancier la class 'Bookrepository' dans la variable '$bookRepository
        $book = $bookRepository ->find(5);
        // la variable '$book' est une entité
        $entityManager->remove($book);
        $entityManager->flush();
     }
}