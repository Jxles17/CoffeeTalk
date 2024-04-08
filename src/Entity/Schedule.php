<?php

namespace App\Entity;

use App\Repository\ScheduleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
class Schedule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_shop = null;

    #[ORM\Column(length: 255)]
    private ?string $day = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $opening_hour = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $closing_hour = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdShop(): ?int
    {
        return $this->id_shop;
    }

    public function setIdShop(int $id_shop): static
    {
        $this->id_shop = $id_shop;

        return $this;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): static
    {
        $this->day = $day;

        return $this;
    }

    public function getOpeningHour(): ?\DateTimeInterface
    {
        return $this->opening_hour;
    }

    public function setOpeningHour(\DateTimeInterface $opening_hour): static
    {
        $this->opening_hour = $opening_hour;

        return $this;
    }

    public function getClosingHour(): ?\DateTimeInterface
    {
        return $this->closing_hour;
    }

    public function setClosingHour(\DateTimeInterface $closing_hour): static
    {
        $this->closing_hour = $closing_hour;

        return $this;
    }
}
