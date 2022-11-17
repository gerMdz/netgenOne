<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Slug;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $subText = null;

    #[ORM\Column(length: 100, unique: true)]
    #[Slug(fields: ['name'])]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    private ?string $imageFilename = null;

    #[ORM\Column(type: Types::JSON)]
    private array $ingredients = [];

    #[ORM\Column(type: Types::JSON)]
    private array $instructions = [];

    #[ORM\Column]
    private ?int $totalTime = null;

    #[ORM\Column(length: 255)]
    private ?string $sourceUrl = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSubText(): ?string
    {
        return $this->subText;
    }

    public function setSubText(string $subText): self
    {
        $this->subText = $subText;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getImageFilename(): ?string
    {
        return $this->imageFilename;
    }

    public function getImageUrl(): string
    {
        return 'uploads/recipes/' . $this->getImageFilename();
    }

    public function setImageFilename(string $imageFilename): self
    {
        $this->imageFilename = $imageFilename;

        return $this;
    }

    public function getIngredients(): array
    {
        return $this->ingredients;
    }

    public function setIngredients(array $ingredients): self
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    public function getInstructions(): array
    {
        return $this->instructions;
    }

    public function setInstructions(array $instructions): self
    {
        $this->instructions = $instructions;

        return $this;
    }

    public function getTotalTime(): ?int
    {
        return $this->totalTime;
    }

    public function setTotalTime(int $totalTime): self
    {
        $this->totalTime = $totalTime;

        return $this;
    }

    public function getTimeAsWords(): string
    {
        if ($this->totalTime < 60) {
            return sprintf('%d minutes', $this->totalTime);
        }

        $hours = floor($this->totalTime / 60);
        // it's always a good day when you can use the modulo operator!
        $minutes = $this->totalTime % 60;

        return sprintf(
            '%s hour%s, %s minutes',
            $hours,
            $hours == 1 ? '' : 's',
            $minutes
        );
    }

    public function getSourceUrl(): ?string
    {
        return $this->sourceUrl;
    }

    public function setSourceUrl(string $sourceUrl): self
    {
        $this->sourceUrl = $sourceUrl;

        return $this;
    }
}
