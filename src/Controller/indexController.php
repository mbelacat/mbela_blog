<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;



class indexController  extends AbstractController
{
  /**
   *@Route("", name="app_acceuil")
   */
  public function acceuil(){
    $repository = $this->getDoctrine()->getRepository(Article::class);
    $articles = $repository->findBy(array(), array("id"=> "DESC") , 3);
    return $this->render("blog/acceuil.html.twig", ["articles" => $articles]);
  }
}




 ?>
