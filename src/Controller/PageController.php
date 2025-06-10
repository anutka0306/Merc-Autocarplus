<?php

namespace App\Controller;

use App\Repository\BrandRepository;
use App\Repository\PromotionRepository;
use App\Service\MetaGenerator;
use App\Service\MetaTemplates;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ModelRepository;
use App\Repository\ServiceRepository;
use App\Repository\ServiceCategoryRepository;

final class PageController extends AbstractController
{
    #[Route('korporativnym-klientam', name: 'korporativnym_klientam')]
    public function corporateClientsPage(): Response
    {
        return $this->render('page/corporate-clients.html.twig', [
        ]);
    }

    #[Route('/remont-i-servis-{modelSlug}/{serviceSlug}/', name: 'model_service_page')]
    public function modelServicePage(
        string $modelSlug,
        string $serviceSlug,
        ModelRepository $modelRepo,
        ServiceRepository $serviceRepo,
        ServiceCategoryRepository $serviceCategoryRepository,
        PromotionRepository $promotionRepository,
        MetaTemplates $templates,
        MetaGenerator $generator
    ): Response {
        $serviceCategory = $serviceCategoryRepository->findAllWithServices();
        $promotions = $promotionRepository->findBy(['active' => true]);
        $model = $modelRepo->findOneBy(['slug' => $modelSlug]);
        $template = $templates->getTemplate('service_model');
        if (!$model) {
            throw $this->createNotFoundException('Модель не найдена');
        }

        $service = $serviceRepo->findOneBy([
            'slug' => $serviceSlug,
        ]);

        if (!$service) {
            $category = $serviceCategoryRepository->findOneBy([
                'slug' => $serviceSlug,
            ]);
            if($category) {
                $service = $category;
            } else {
                throw $this->createNotFoundException('Услуга для модели не найдена');
            }
        }

        $meta = $generator->generate($template, [
            'brand_en' => $model->getBrand()->getName(),
            'model_en' => $model->getNameEn(),
            'brand_ru' => $model->getBrand()->getNameRu(),
            'model_ru' => $model->getNameRu(),
            'service_name' => $service->getName(),
        ]);

        return $this->render('service/model.html.twig', [
            'model' => $model,
            'service' => $service,
            'promotions' => $promotions,
            'servicesCategory' => $serviceCategory,
            'meta' =>$meta,
        ]);
    }


    #[Route('/remont-i-servis-{slug}/', name: 'model')]
    public function model(
        string $slug,
        ModelRepository $modelRepo,
        ServiceRepository $serviceRepo,
        ServiceCategoryRepository $serviceCategoryRepository,
        PromotionRepository $promotionRepository,
        MetaTemplates $templates,
        MetaGenerator $generator
    ): Response {
        $serviceCategory = $serviceCategoryRepository->findAllWithServices();
        $promotions = $promotionRepository->findBy(['active' => true]);
        $template = $templates->getTemplate('model');

        $model = $modelRepo->findOneBy(['slug' => $slug]);
        if ($model) {
            $meta = $generator->generate($template, [
                'brand_en' => $model->getBrand()->getName(),
                'model_en' => $model->getNameEn(),
                'brand_ru' => $model->getBrand()->getNameRu(),
                'model_ru' => $model->getNameRu(),
            ]);
            return $this->render('model/show.html.twig', [
                'model' => $model,
                'promotions' => $promotions,
                'servicesCategory' => $serviceCategory,
                'meta' => $meta,
            ]);
        }
        throw $this->createNotFoundException('Страница не найдена');
    }

    #[Route('/{slug}/', name: 'main_service', requirements: ['slug' => '[a-z0-9\-]+'])]
    public function mainServicePage(
        string $slug,
        ServiceRepository $serviceRepo,
        ServiceCategoryRepository $serviceCategoryRepository,
        PromotionRepository $promotionRepository,
        BrandRepository $brandRepository,
        MetaTemplates $templates,
        MetaGenerator $generator
    ): Response {
        $service = $serviceRepo->findOneBy([
            'slug' => $slug,
        ]);

        $serviceCategory = $serviceCategoryRepository->findAllWithServices();
        $promotions = $promotionRepository->findBy(['active' => true]);
        $brand = $brand = $brandRepository->findOneBy([]);
        $template = $templates->getTemplate('service');

        if ($service) {
            $meta = $generator->generate($template, [
                'brand_en' => $brand->getName(),
                'brand_ru' => $brand->getNameRu(),
                'service_name' => $service->getName(),
            ]);

            return $this->render('service/index.html.twig', [
                'service' => $service,
                'promotions' => $promotions,
                'servicesCategory' => $serviceCategory,
                'brand' => $brand,
                'meta' => $meta,
            ]);
        }

        $category = $serviceCategoryRepository->findOneBy([
            'slug' => $slug,
        ]);

        if($category) {
            $meta = $generator->generate($template, [
                'brand_en' => $brand->getName(),
                'brand_ru' => $brand->getNameRu(),
                'service_name' => $category->getName(),
            ]);

            return $this->render('category/index.html.twig', [
                'service' => $category,
                'promotions' => $promotions,
                'servicesCategory' => $serviceCategory,
                'brand' => $brand,
                'meta' => $meta,
            ]);
        }
        throw $this->createNotFoundException('Услуга или категория не найдена');

    }

}
