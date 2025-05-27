<?php

namespace App\Controller;

use App\Repository\ModelRepository;
use App\Repository\PromotionRepository;
use App\Repository\ServiceCategoryRepository;
use App\Service\MetaGenerator;
use App\Service\MetaTemplates;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        ModelRepository $modelRepository,
        PromotionRepository $promotionRepository,
        ServiceCategoryRepository $serviceCategoryRepository,
        MetaTemplates $templates,
        MetaGenerator $generator,
    ): Response
    {
        $template = $templates->getTemplate('home');
        $meta = $generator->generate($template, []);
        $models = $modelRepository->findAll();
        $serviceCategory = $serviceCategoryRepository->findAllWithServices();
        $promotions = $promotionRepository->findBy(['active' => true]);

        return $this->render('home/index.html.twig', [
            'models' => $models,
            'promotions' => $promotions,
            'servicesCategory' => $serviceCategory,
            'meta' => $meta,
        ]);
    }
}
