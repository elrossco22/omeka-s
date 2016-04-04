<?php
namespace Omeka\Media\FileRenderer;

use Omeka\Api\Representation\MediaRepresentation;
use Zend\View\Renderer\PhpRenderer;

class ThumbnailRenderer implements RendererInterface
{
    public function render(PhpRenderer $view, MediaRepresentation $media,
        array $options = []
    ) {
        $thumbnailType = isset($options['thumbnailType']) ? $options['thumbnailType'] : 'large';
        $link = isset($options['link']) ? $options['link'] : 'original';
        $img = sprintf('<img src="%s">', $view->escapeHtml($media->thumbnailUrl($thumbnailType)));
        if ($link) {
            $url = $this->getLinkUrl($media, $link);
            return sprintf('<a href="%s">%s</a>', $view->escapeHtml($url), $img);
        }
        return $img;
    }

    /**
     * Get the URL for the given type of link
     *
     * @param MediaRepresentation $media
     * @param string $linkType Type of link: 'original', 'item', and 'media' are valid
     * @throws InvalidArgumentException On unrecognized $linkType
     * @return string
     */
    protected function getLinkUrl(MediaRepresentation $media, $linkType)
    {
        switch ($linkType) {
            case 'original':
                return $media->originalUrl();
            case 'item':
                return $media->item()->url();
            case 'media':
                return $media->url();
            default:
                throw new \InvalidArgumentException(sprintf('Invalid link type "%s"', $linkType));
        }
    }
}
