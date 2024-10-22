<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send email to
 * to license@software.com so we can send you a copy immediately.
 */

namespace Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PrestaShop\PrestaShop\Core\Language\LanguageInterface;

class Entity implements LanguageInterface
{
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=32)
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="iso_code", type="string", length=2)
     */
    private $isoCode;

    /**
     * @var string
     *
     * @ORM\Column(name="language_code", type="string", length=5)
     */
    private $languageCode;

    /**
     * @var string
     *
     * @ORM\Column(name="locale", type="string", length=5)
     */
    private $locale;

    /**
     * Badly named, it's not really light. It's just the format for a date only.
     *
     * @var string
     *
     * @ORM\Column(name="date_format_lite", type="string", length=32)
     */
    private $dateFormatLite;

    /**
     * Badly named, it's not full. It's just the format for a date AND time.
     *
     * @var string
     *
     * @ORM\Column(name="date_format_full", type="string", length=32)
     */
    private $dateFormatFull;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_rtl", type="boolean")
     */
    private $isRtl;

    /**
     * @ORM\OneToMany(targetEntity="Translation", mappedBy="lang")
     */
    private $translations;

    /**
     * @ORM\ManyToMany(targetEntity="PrestaShopBundle\Entity\Shop", cascade={"remove", "persist"})
     * @ORM\JoinTable(
     *      joinColumns={@ORM\JoinColumn(name="id_lang", referencedColumnName="id_lang", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_shop", referencedColumnName="id_shop", onDelete="CASCADE")}
     * )
     */
    private $shops;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->shops = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Entity
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set active.
     *
     * @param bool $active
     *
     * @return Entity
     */
    public function setActive(bool $active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active.
     *
     * @return bool
     */
    public function getActive(): bool
    {
        return $this->active;
    }

    /**
     * Set isoCode.
     *
     * @param string $isoCode
     *
     * @return Entity
     */
    public function setIsoCode(string $isoCode)
    {
        $this->isoCode = $isoCode;

        return $this;
    }

    /**
     * Get isoCode.
     *
     * @return string
     */
    public function getIsoCode(): string
    {
        return $this->isoCode;
    }

    /**
     * Set languageCode.
     *
     * @param string $languageCode
     *
     * @return Entity
     */
    public function setLanguageCode(string $languageCode)
    {
        $this->languageCode = $languageCode;

        return $this;
    }

    /**
     * Get languageCode.
     *
     * @return string
     */
    public function getLanguageCode(): string
    {
        return $this->languageCode;
    }

    /**
     * Set dateFormatLite.
     *
     * @param string $dateFormatLite
     *
     * @return Entity
     */
    public function setDateFormatLite(string $dateFormatLite)
    {
        $this->dateFormatLite = $dateFormatLite;

        return $this;
    }

    /**
     * Get dateFormatLite.
     *
     * @return string
     */
    public function getDateFormatLite(): string
    {
        return $this->dateFormatLite;
    }

    /**
     * {@inheritdoc}
     */
    public function getDateFormat(): string
    {
        return $this->dateFormatLite;
    }

    /**
     * Set dateFormatFull.
     *
     * @param string $dateFormatFull
     *
     * @return Entity
     */
    public function setDateFormatFull(string $dateFormatFull)
    {
        $this->dateFormatFull = $dateFormatFull;

        return $this;
    }

    /**
     * Get dateFormatFull.
     *
     * @return string
     */
    public function getDateFormatFull(): string
    {
        return $this->dateFormatFull;
    }

    /**
     * {@inheritdoc}
     */
    public function getDateTimeFormat(): string
    {
        return $this->dateFormatFull;
    }

    /**
     * Set isRtl.
     *
     * @param bool $isRtl
     *
     * @return Entity
     */
    public function setIsRtl($isRtl)
    {
        $this->isRtl = $isRtl;

        return $this;
    }

    /**
     * Get isRtl.
     *
     * @return bool
     */
    public function getIsRtl(): bool
    {
        return $this->isRtl;
    }

    /**
     * {@inheritdoc}
     */
    public function isRTL(): bool
    {
        return $this->getIsRtl();
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return !empty($this->locale) ? $this->locale : $this->getLanguageCode();
    }

    /**
     * @param string $locale
     *
     * @return Entity
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Add shop.
     *
     * @param Shop $shop
     *
     * @return Entity
     */
    public function addShop(Shop $shop)
    {
        $this->shops[] = $shop;

        return $this;
    }

    /**
     * Remove shop.
     *
     * @param Shop $shop
     */
    public function removeShop(Shop $shop)
    {
        $this->shops->removeElement($shop);
    }

    /**
     * Get shops.
     *
     * @return Collection
     */
    public function getShops()
    {
        return $this->shops;
    }

    /**
     * Get translations.
     *
     * @return Collection
     */
    public function getTranslations()
    {
        return $this->translations;
    }
}
