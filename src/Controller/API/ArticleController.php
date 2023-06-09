<?php

namespace App\Controller\API;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
  /**
   * @Route("/api/articles", name="app_api_article_list")
   */
    public function getAll(ArticleRepository $articleRepository): JsonResponse
    {
      return $this->json($articleRepository->findAll(), Response::HTTP_OK, [], ["groups" => "articles"]);
    }


    /**
     * @Route("/api/articles/{id}", name="app_api_article_getOneById", methods={"GET"}, requirements={"id"="\d+"})
     */
     public function getOne(Article $article): JsonResponse
    {
      return $this->json($article,Response::HTTP_OK,[],["groups" => "articles"]);
    }

    /**
     * @Route("/api/articles/{page}/{articles}", name="app_api_article_getPerPage", methods={"GET"}, requirements={"page"="\d+", "articles"="\d+"})
     */
    public function getPerPage(int $page, int $articles, ArticleRepository $articleRepository): JsonResponse
    {

      $articles = $articleRepository->findArticlesPerPage($page, $articles);

      return $this->json($articles,Response::HTTP_OK,[],["groups" => "articles"]);
    }
}

