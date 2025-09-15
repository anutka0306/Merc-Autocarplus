<?php

namespace App\Twig;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class GalleryExtension extends AbstractExtension
{
    private string $galleryPath = '/uploads/gallery';
    private array $fixedHomeFiles = [
        'home1.jpg',
        'home2.jpg',
        'home3.jpg',
        'home4.jpg',
        'home5.jpg',
        'home6.jpg',
    ];

    public function __construct(private CacheInterface $cache) {}

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_files_for_gallery', [$this, 'getFilesForGallery']),
        ];
    }

    /**
     * Возвращает массив файлов для галереи.
     *
     * @param string $pathInfo текущий URL-путь (например, app.request.pathInfo)
     * @return array
     */
    public function getFilesForGallery(string $pathInfo): array
    {
        // Главная страница — фиксированные 6 фото
        if ($pathInfo === '/') {
            return array_map(fn($f) => $this->galleryPath . '/' . $f, $this->fixedHomeFiles);
        }

        // Все остальные страницы — кешируем по URL
        $cacheKey = 'gallery_random_files_' . md5($pathInfo);

        return $this->cache->get($cacheKey, function (ItemInterface $item) {
            $item->expiresAfter(86400); // 24 часа

            $allFiles = glob($_SERVER['DOCUMENT_ROOT'] . $this->galleryPath . '/*.{jpg,jpeg,png,webp}', GLOB_BRACE);

            if (!$allFiles) {
                return [];
            }

            shuffle($allFiles);
            $selected = array_slice($allFiles, 0, 6);

            // Возвращаем пути относительно public
            return array_map(fn($path) => str_replace($_SERVER['DOCUMENT_ROOT'], '', $path), $selected);
        });
    }
}
