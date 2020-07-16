<?php


namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminBookController extends AbstractController
{
    /**
     * @Route("/admin/book_delete", name="Admin_Book_Delete")
     */
    public function AdminBookDelete(BookRepository $bookRepository)
    {
       $book = $bookRepository ->findAll();
       return $this->render('Book/adminBook.html.twig',[
           'book' =>$book
        ]);
    }

}