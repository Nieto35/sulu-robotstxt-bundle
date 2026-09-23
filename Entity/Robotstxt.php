<?php
/*
 * This file is part of the Sulu Robotstxt bundle.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace BitExpert\Sulu\RobotstxtBundle\Entity;

use BitExpert\Sulu\RobotstxtBundle\Repository\RobotstxtRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RobotstxtRepository::class)]
class Robotstxt
{
    final public const RESOURCE_KEY = 'robotstxt';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    // @phpstan-ignore-next-line
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255, unique: true, nullable: false)]
    private ?string $webspace_key = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWebspaceKey(): ?string
    {
        return $this->webspace_key;
    }

    public function setWebspaceKey(?string $webspace_key): self
    {
        $this->webspace_key = $webspace_key;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}