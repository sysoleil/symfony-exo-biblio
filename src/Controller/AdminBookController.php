<?php


namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminBookController extends AbstractController
{
    /**
     * @Route("/admin/book", name="admin_book")
     */
    public function adminBook(BookRepository $bookRepository)
    {
       $books = $bookRepository ->findAll();
       return $this->render('administrateur/adminBook.html.twig',[
           'books' =>$books

        ]);
    }
    /**
     * @Route("/admin/book_delete/{id}", name="admin_book_delete")
     */
    public function AdminBookDelete(BookRepository $bookRepository, EntityManagerInterface $entityManager, $id)
    {
        $book = $bookRepository ->find($id);

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('admin_book');
    }

    /**
     * @Route("/admin/book_insert/", name="admin_book_insert")
     */
    public function adminBookInsert (
        Request $request,
        EntityManagerInterface $entityManager)
    {
        //Cette méthode Request permet de récupérer les données de la méthode post
        //Je crée une nouvelle instance de l'entité book
        $book = new  Book();

        // je récupère le gabarit de formulaire de
        // l'entité Book, créé  dans la console avec la commande make:form
        // et je le stocke dans une variable $bookForm
        $bookForm = $this->createForm(BookType::class, $book);

        // je prends les données de la requête (class Request)

        //et je les "envoie" à mon formulaire
        $bookForm->handleRequest($request);

        // si le formulaire a été envoyé et que les données sont valides
        // par rapport à celles attendues alors je 'persist' (commit) le livre
        // puis je le flush pour enregistrer les nouvelles données dans ma BDD
        if ($bookForm->isSubmitted() && $bookForm->isValid()){
            $entityManager->persist($book);
            $entityManager->flush();

            $this->addFlash('success','Votre livre a bien été créé');
            // Je crée une méthode 'addFlash' qui va appeler le message si le type a réussi
            //puis je vais mettre le lien dans la base car c'est une action répétitive

            return $this->redirectToRoute('admin_book');
        }
        // je retourne mon fichier twig, en lui envoyant
        // la vue du formulaire, générée avec la méthode createView()
        return $this->render('administrateur/adminBookInsert.html.twig',[
            'bookForm' =>$bookForm ->createView()
        ]);
    }
    /**
     *@Route("/admin/book_update/{id}", name="admin_book_update")
     */
    public function adminBookUpdate(
        Request $request,
        EntityManagerInterface $entityManager,
        BookRepository $bookRepository,
        $id)
    {
        $book = $bookRepository->find($id);

        $bookForm = $this->createForm(BookType::class, $book);

        $bookForm->handleRequest($request);

        if ($bookForm->isSubmitted() && $bookForm->isValid()) {
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('admin_book');
        }
        return $this->render('administrateur/adminBookUpdate.html.twig', [
            'bookForm' => $bookForm->createView()
        ]);
    }
}