<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Service\SlurWordsControl;



class articleController  extends AbstractController


{


  /**
   *@Route("/article/{id}",name= "app_single",requirements={"id"="\d+"})
   */
  public function showArticle($id = 1, SlurWordsControl $slurWordsControl ){
    $repository = $this->getDoctrine()->getRepository(Article::class);
    $article = $repository->find($id);
    $newcontent = $slurWordsControl->replaceSlur($article->getContent());
    $article->setContent($newcontent);
    return $this->render("blog/article.html.twig", ["article" => $article]);
  }

  /**
   *@Route("/admin/article/add",name= "app_add_article")
   */
  public function addArticle(){

    return new response("ajouter");
    // return $this->redirectToRoute('/admin/article/add');
  }


  /**
    * @Route("/product", name="product")
    */
   public function index()
   {
       // you can fetch the EntityManager via $this->getDoctrine()
       // or you can add an argument to your action: index(EntityManagerInterface $entityManager)
       $entityManager = $this->getDoctrine()->getManager();

       $article = new Article();
       $article->setTitle('Diegi Rivera');
       $article->setContent("Rivera reçoit une bourse de Teodoro A. Dehesa Méndez (es), alors gouverneur de l'État de Veracruz et l'un des piliers du gouvernement de Porfirio Díaz, ce qui lui permet d'étudier en Europe, d'abord à Madrid, en 1907. En mars 1909, il achève ses études et déménage à Paris, puis quelques semaines après, il fait un tour de l'Europe du Nord, visite Bruges et les Pays-Bas ainsi que Londres. Lors d'un voyage à Bruxelles en 1909 avec María Blanchard, il rencontre la peintre russe Angelina Beloff, avec laquelle il visite la Bretagne et qu'il épouse à Paris. Elle sera sa compagne pendant douze ans4. En 1910, il commence à étudier chez le peintre impressionniste Octave Guillonnet.
       ");
       $article->setCreated_at(new \DateTime('@'.strtotime('now')));
       $article->setAuthor_name("mbela");
       $article->setCategory("art");
       $article->setNumber_view(5);


       // tell Doctrine you want to (eventually) save the Product (no queries yet)
       $entityManager->persist($article);

       // actually executes the queries (i.e. the INSERT query)
       $entityManager->flush();

       return new Response('Saved new product with id '.$article->getId());
   }

}




 ?>
