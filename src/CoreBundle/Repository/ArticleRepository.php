<?php

namespace CoreBundle\Repository;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends \Doctrine\ORM\EntityRepository
{
  //Function to get articles on the home page
  public function getArticlesImagesAndCategories() {
    $articles = $this->createQueryBuilder('a')
    ->orderBy("a.id", "DESC")
    ->setMaxResults(5)
    ->leftJoin("a.image", "img")
    ->addSelect("img")
    ->leftJoin("a.categories", "cat")
    ->addSelect("cat")
    ->getQuery()
    ->getResult();

    return $articles;
  }

  //Articles sorted by modules
  public function getArticlesImagesByModule($module) {
    $articles = $this->createQueryBuilder('a')
    ->where("a.module = :module")
    ->setParameter('module', $module)
    ->orderBy('a.dispatch', 'ASC')
    ->leftJoin("a.image", "img")
    ->addSelect("img")
    ->leftJoin("a.categories", "cat")
    ->addSelect("cat")
    ->getQuery()
    ->getResult();

    return $articles;
  }
  //Default request for the admin index article page
  public function getArticlesWithCategoryModules() {
    $articles = $this->createQueryBuilder('a')
    ->leftjoin("a.categories", "ctg")
    ->addSelect("ctg")
    ->leftjoin("a.module", "mod")
    ->addSelect("mod")
    ->getQuery()
    ->getResult();

    return $articles;

  }
}
