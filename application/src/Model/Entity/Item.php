<?php
namespace Omeka\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 */
class Item extends Resource
{
    /**
     * @Id
     * @Column(type="integer")
     */
    protected $id;

    /**
     * @Column(type="boolean")
     */
    protected $isPublic = false;

    /**
     * @OneToMany(
     *     targetEntity="Media",
     *     mappedBy="item",
     *     orphanRemoval=true,
     *     cascade={"persist", "remove", "detach"}
     * )
     */
    protected $media;

    /**
     * @OneToMany(targetEntity="SiteItem", mappedBy="item")
     */
    protected $siteItems;

    /**
     * @ManyToMany(targetEntity="ItemSet", inversedBy="items", indexBy="id")
     * @JoinTable(name="item_item_set")
     */
    protected $itemSets;

    public function __construct() {
        parent::__construct();
        $this->media = new ArrayCollection;
        $this->siteItems = new ArrayCollection;
        $this->itemSets = new ArrayCollection;
    }

    public function getResourceName()
    {
        return 'items';
    }

    public function getId()
    {
        return $this->id;
    }

    public function setIsPublic($isPublic)
    {
        $this->isPublic = (bool) $isPublic;
    }

    public function isPublic()
    {
        return (bool) $this->isPublic;
    }

    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Add media to this item.
     *
     * @param Media $media
     */
    public function addMedia(Media $media)
    {
        $media->setItem($this);
    }

    /**
     * Remove media from this item.
     *
     * @param Media $media
     */
    public function removeMedia(Media $media)
    {
        $media->setItem(null);
    }

    public function getSiteItems()
    {
        return $this->siteItems;
    }

    public function getItemSets()
    {
        return $this->itemSets;
    }
}
