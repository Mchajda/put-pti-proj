<?php

namespace App\Controller\Admin;

use App\Provider\Interfaces\CategoryProviderInterface;
use App\RequestProcessor\Interfaces\CategoryRequestProcessorInterface;
use App\Service\Interfaces\CategoryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    private $categoryProvider;
    private $categoryRequestProcessor;
    private $categoryService;

    public function __construct(
        CategoryProviderInterface $categoryProvider,
        CategoryRequestProcessorInterface $categoryRequestProcessor,
        CategoryServiceInterface $categoryService
    ){
        $this->categoryProvider = $categoryProvider;
        $this->categoryRequestProcessor = $categoryRequestProcessor;
        $this->categoryService = $categoryService;
    }

    /**
     * @Route("/amdin/categories", name="admin_categories")
     */
    public function index(): Response
    {
        $categories = $this->categoryProvider->getAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }
}
