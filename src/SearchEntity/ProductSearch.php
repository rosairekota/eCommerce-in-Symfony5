<?php

namespace App\SearchEntity;

use Symfony\Component\Validator\Constraints as  Assert;

class ProductSearch
{
    /**
     * @var string
     * @Assert\Length(min=3, max=20, minMessage="Ce type de service n'est pas disponible")
     */
    private $title;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }
}
