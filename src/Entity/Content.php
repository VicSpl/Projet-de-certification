<?php

namespace App\Entity;

use App\Repository\ContentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContentRepository::class)
 */
class Content
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $articleContent;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $articleTitle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $page;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=511, nullable=true)
     */
    private $link;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticleContent(): ?string
    {
        return $this->articleContent;
    }

    public function setArticleContent(?string $articleContent): self
    {
        $this->articleContent = $articleContent;

        return $this;
    }

    public function getArticleTitle(): ?string
    {
        return $this->articleTitle;
    }

    public function setArticleTitle(?string $articleTitle): self
    {
        $this->articleTitle = $articleTitle;

        return $this;
    }

    public function getPage(): ?string
    {
        return $this->page;
    }

    public function setPage(string $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }
}
