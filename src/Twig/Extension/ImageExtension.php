<?php

namespace Bolt\Twig\Extension;

use Bolt\Twig\Runtime;
use Twig_Extension as Extension;
use Twig_Filter as TwigFilter;
use Twig_Function as TwigFunction;

/**
 * Image functionality Twig extension.
 *
 * @internal
 *
 * @author Gawain Lynch <gawain.lynch@gmail.com>
 */
class ImageExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        $safe = ['is_safe' => ['html']];

        return [
            // @codingStandardsIgnoreStart
            new TwigFunction('image',     [Runtime\ImageRuntime::class, 'image']),
            new TwigFunction('imageinfo', [Runtime\ImageRuntime::class, 'imageInfo']),
            new TwigFunction('popup',     [Runtime\ImageRuntime::class, 'popup'], $safe),
            new TwigFunction('showimage', [Runtime\ImageRuntime::class, 'showImage'], $safe),
            new TwigFunction('thumbnail', [Runtime\ImageRuntime::class, 'thumbnail']),
            // @codingStandardsIgnoreEnd
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        $safe = ['is_safe' => ['html']];
        $deprecated = ['deprecated' => true];

        return [
            // @codingStandardsIgnoreStart
            new TwigFilter('image',     [Runtime\ImageRuntime::class, 'image']),
            new TwigFilter('imageinfo', [Runtime\ImageRuntime::class, 'imageInfo']),
            new TwigFilter('popup',     [Runtime\ImageRuntime::class, 'popup'], $safe),
            new TwigFilter('showimage', [Runtime\ImageRuntime::class, 'showImage'], $safe),
            new TwigFilter('thumbnail', [Runtime\ImageRuntime::class, 'thumbnail']),
            // @codingStandardsIgnoreEnd
        ];
    }
}
