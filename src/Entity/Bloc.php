<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\BlocRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: BlocRepository::class)]
#[Vich\Uploadable]
#[ApiResource(
    types: ['https://schema.org/Book'],
    operations: [
        new GetCollection(),
        new Post(inputFormats: ['multipart' => ['multipart/form-data']])
    ],
    normalizationContext: ['groups' => ['bloc:read']],
    denormalizationContext: ['groups' => ['bloc:write']]
)]
class Bloc
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['bloc:read'])]
    private ?int $id = null;

    #[Groups(['bloc:write','bloc:read'])]
    #[ORM\Column(length: 500, nullable: true)]
    private ?string $title = null;

    #[ApiProperty(types: ['https://schema.org/contentUrl'])]
    #[Groups(['bloc:read'])]
    public ?string $contentUrl = null;

    #[Vich\UploadableField(mapping: 'image', fileNameProperty: 'filePath')]
    #[Groups(['bloc:write','bloc:read'])]
    public ?File $file = null;

    #[Groups(['bloc:write','bloc:read'])]
    #[ORM\Column(nullable: true)]
    public ?string $filePath = null;

    #[Groups(['bloc:write','bloc:read'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $paragraph = null;

    #[Groups(['bloc:write','bloc:read'])]
    #[ORM\Column(length: 500, nullable: true)]
    private ?string $chart = null;

    #[Groups(['bloc:write','bloc:read'])]
    #[ORM\ManyToMany(targetEntity: Article::class, mappedBy: 'blocs')]
    private Collection $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getParagraph(): ?string
    {
        return $this->paragraph;
    }

    public function setParagraph(?string $paragraph): static
    {
        $this->paragraph = $paragraph;

        return $this;
    }

    public function getChart(): ?string
    {
        return $this->chart;
    }

    public function setChart(?string $chart): static
    {
        $this->chart = $chart;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): static
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->addBloc($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): static
    {
        if ($this->articles->removeElement($article)) {
            $article->removeBloc($this);
        }

        return $this;
    }
}
