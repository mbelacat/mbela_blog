<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\SlurWordsControl;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Article;



class articleController  extends AbstractController
{

  /**
   * Matches /blog/*
   *
   * @Route("/blog/{slug}", name="app_single", requirements={"id"="\d+"})
   */
  public function showArticle($slug = 1, SlurWordsControl $slurWordsControl ){
    $repository = $this->getDoctrine()->getRepository(Article::class);
    $article = $repository->find($slug);
    $newcontent = $slurWordsControl->replaceSlur($article->getContent());
    $article->setContent($newcontent);
    return $this->render("blog/article.html.twig", ["article" => $article]);
  }

  /**
   *@Route("/admin/article/add",name= "app_add_article", requirements={"roles"="ROLE_ADMIN"})
   */
  public function addArticle(Request $request){
    $repository = $this->getDoctrine()->getRepository(Article::class);
        $article = new Article();

        $form = $this->createFormBuilder($article)
            ->add('title', TextType::class, [
              'label' => 'Titre',
            ])
            ->add('category', TextType::class, [
              'label' => 'Categorie',
            ])
            ->add('content', TextareaType::class, [
              'label' => 'Contenu',
            ])
            ->add('save', SubmitType::class, ['label' => 'Créer Article'])
            ->getForm();
        $form->handleRequest($request);
        $article->setCreated_at(new \DateTime('@'.strtotime('now')));


        if ($form->isSubmitted() && $form->isValid()) {
          $userName = $this->getUser()->getUser_name();
          $article->setAuthorName( $userName);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            $this->addFlash(
            'notice',
            'Your changes were saved!'
        );
            return $this->redirectToRoute('app_list_articles');
        }

        return $this->render('/blog/addArticle.html.twig', [
            'article' => $article,
            'form' => $form->createView(),

        ]);
  }


  /**
   *@Route("/articles", name = "app_list_articles")
   */
  public function listArticles(){
    $repository = $this->getDoctrine()->getRepository(Article::class);
    $articles = $repository->findAll();
    return $this->render("blog/listArticles.html.twig", ["articles" => $articles]);
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
       $article->setTitle('Rene Magritte');
       $article->setContent("René François Ghislain Magritte est le fils de Léopold Magritte, tailleur2, et de Régina Bertinchamps, modiste3. La famille emménage d'abord à Soignies puis à Saint-Gilles, Lessines, là où naît René Magritte, et en 1900 retourne chez la mère de Régina à Gilly4, où naissent ses deux frères Raymond (1900-1970) et Paul (1902-1975). En 1904, ses parents s'installent à Châtelet où, après avoir exercé divers métiers, le père du peintre s'enrichit en devenant l'année suivante inspecteur général de la société De Bruyn qui produit huile et margarine5.");
       $article->setCreated_at(new \DateTime('@'.strtotime('now')));
       $article->setAuthor_name("mbela");
       $article->setCategory("art");
       $article->setNumber_view(9);

       // tell Doctrine you want to (eventually) save the Product (no queries yet)
       $entityManager->persist($article);

       // actually executes the queries (i.e. the INSERT query)
       $entityManager->flush();

       return new Response('Saved new product with id '.$article->getId());
   }

}




 ?>
