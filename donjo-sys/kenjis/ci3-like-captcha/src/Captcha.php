<?php

declare(strict_types=1);

namespace Kenjis\CI3Like\Captcha;

use SimpleCaptcha\Builder;

use function assert;
use function is_string;
use function microtime;
use function rtrim;

class Captcha
{
    /**
     * Create CAPTCHA
     *
     * @param   array<string, string|int>|string $data     Data for the CAPTCHA
     * @param   string                           $imgPath  Path to create the image in (deprecated)
     * @param   string                           $imgUrl   URL to the CAPTCHA image folder (deprecated)
     * @param   string                           $fontPath Server path to font (deprecated)
     *
     * @return  array<string, mixed>
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public static function createCaptcha(
        $data = '',
        string $imgPath = '',
        string $imgUrl = '',
        string $fontPath = ''
    ): array {
        $now = microtime(true);
        $imgFilename = $now . '.png';

        if (isset($data['img_path'])) {
            $imgPath = $data['img_path'];
        }

        if (isset($data['img_url']) && is_string($data['img_url'])) {
            $imgUrl = $data['img_url'];
        }

        $word = $data['word'] ?? null;

        assert(is_string($word) || ($word === null));

        $imgTag = self::createImageTag($data, $imgUrl, $imgFilename);

        $builder = new Builder($word);
        $builder->build();
        $builder->save($imgPath . $imgFilename);

        return [
            'word' => $word ?? $builder->phrase,
            'time' => $now,
            'image' => $imgTag,
            'filename' => $imgFilename,
        ];
    }

    /**
     * @param array<string, string|int>|string $data
     */
    private static function createImageTag($data, string $imgUrl, string $imgFilename): string
    {
        $imgId = $data['img_id'] ?? '';
        $imgSrc = rtrim($imgUrl, '/') . '/' . $imgFilename;
        $imgWidth = $data['img_width'] ?? 150;
        $imgHeight = $data['img_height'] ?? 30;
        $imgAlt = $data['img_alt'] ?? 'captcha';

        return '<img ' . ($imgId === '' ? '' : 'id="' . $imgId . '"')
            . ' src="' . $imgSrc . '" style="width: ' . $imgWidth
            . 'px; height: ' . $imgHeight . 'px; border: 0;" alt="'
            . $imgAlt . '" />';
    }
}
