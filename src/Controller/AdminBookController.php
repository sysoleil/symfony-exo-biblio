<?php


namespace App\Controller;

use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminBookController extends AbstractController
{
    /**
     * @Route("/admin/book", name="Admin_Book")
     */
    public function AdminBook(BookRepository $bookRepository)
    {
       $books = $bookRepository ->findAll();
       return $this->render('administrateur/adminBook.html.twig',[
           'books' =>$books

        ]);
    }
    /**
     * @Route("/admin/book_delete/{id}", name="Admin_Book_Delete")
     */
    public function AdminBookDelete(BookRepository $bookRepository, EntityManagerInterface $entityManager, $id)
    {
        $book = $bookRepository ->find($id);

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('Admin_Book');
    }
}