<?php

// src/Service/MetaGenerator.php

namespace App\Service;

class MetaGenerator
{
    public function generate(array $template, array $replacements = []): array
    {
        $result = [];
        foreach ($template as $key => $value) {
            foreach ($replacements as $placeholder => $replacement) {
                $value = str_replace('#' . strtoupper($placeholder) . '#', $replacement, $value);
            }
            $result[$key] = preg_replace('/#\w+#/', '', $value); // удаляем неиспользованные плейсхолдеры
        }
        return $result;
    }
}

