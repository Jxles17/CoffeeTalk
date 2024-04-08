<?php

namespace App\Entity;

use App\Repository\RewardpointRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RewardpointRepository::class)]
class Rewardpoint
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_user = null;

    #[ORM\Column(type: Types::BINARY)]
    private $type_transaction;

    #[ORM\Column]
    private ?int $nb_point = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_transaction = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?int
    {
        return $this->id_user;
    }

    public function setIdUser(int $id_user): static
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getTypeTransaction()
    {
        return $this->type_transaction;
    }

    public function setTypeTransaction($type_transaction): static
    {
        $this->type_transaction = $type_transaction;

        return $this;
    }

    public function getNbPoint(): ?int
    {
        return $this->nb_point;
    }

    public function setNbPoint(int $nb_point): static
    {
        $this->nb_point = $nb_point;

        return $this;
    }

    public function getDateTransaction(): ?\DateTimeInterface
    {
        return $this->date_transaction;
    }

    public function setDateTransaction(\DateTimeInterface $date_transaction): static
    {
        $this->date_transaction = $date_transaction;

        return $this;
    }
}
