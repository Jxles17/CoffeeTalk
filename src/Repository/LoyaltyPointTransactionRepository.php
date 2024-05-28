<?php

namespace App\Entity;

use App\Repository\LoyaltyPointTransactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LoyaltyPointTransactionRepository::class)
 */
class LoyaltyPointTransaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    // Définissez d'autres propriétés et méthodes nécessaires ici
}
