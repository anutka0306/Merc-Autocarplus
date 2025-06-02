<?php

namespace App\Service;

class MetaTemplates
{
    public const PAGE_TYPES = [
        'home' => [
            'title' => 'Ремонт и сервис Mercedes-Benz цена в Москве | Автосервис Мерседес-Бенц Грац-Авто',
            'description' => 'Ремонт Мерседес-Бенц в Москве. ⭐ Специализированный автосервис Mercedes-Benz Грац-Авто. ✔ Скидки до 25%. ✔ 2 года гарантии. ✔ Запчасти в наличии.',
        ],
        'model' => [
            'title' => 'Ремонт и сервис #BRAND_RU# #MODEL_RU# (#BRAND_EN# #MODEL_EN#) цена в Москве | Автосервис Грац-Авто Мерседес',
            'description' => 'Ремонт #BRAND_EN# #MODEL_EN# (#BRAND_RU# #MODEL_RU#) в Москве. ⭐ Специализированный Автосервис Грац-Авто Мерседес. ✔️ Скидки до 25%. ✔️ 2 года гарантии. ✔️ Запчасти в наличии',
        ],
        'service_model' => [
            'title' => '#SERVICE_NAME# #BRAND_RU# #MODEL_RU# (#BRAND_EN# #MODEL_EN#) в Москве | Грац-Авто Мерседес',
            'description' => '#SERVICE_NAME# #BRAND_EN# #MODEL_EN# (#BRAND_RU# #MODEL_RU#) в Москве. ⭐ Профильный сервис Грац-Авто Мерседес. ✔️ Скидки до 25%. ✔️ до 2 лет гарантии. ✔️ Запчасти в наличии.',
        ],
        'service' => [
            'title' => '#SERVICE_NAME# #BRAND_RU# (#BRAND_EN#) в Москве | Грац-Авто Мерседес',
            'description' => '#SERVICE_NAME# #BRAND_EN# (#BRAND_RU#) в Москве. ⭐ Профильный сервис Грац-Авто Мерседес. ✔️ Скидки до 25%. ✔️ до 2 лет гарантии. ✔️ Запчасти в наличии.',
        ],
    ];

    public function getTemplate(string $pageType): array
    {
        return self::PAGE_TYPES[$pageType] ?? [];
    }
}

