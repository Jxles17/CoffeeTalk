<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240528114115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
{
    // this up() migration is auto-generated, please modify it to your needs
    $this->addSql('ALTER TABLE event ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, CHANGE datetime datetime DATETIME DEFAULT NULL');
    $this->addSql('ALTER TABLE produit ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
    $this->addSql('ALTER TABLE user CHANGE created_at created_at DATETIME DEFAULT NULL');
}

public function down(Schema $schema): void
{
    // this down() migration is auto-generated, please modify it to your needs
    $this->addSql('ALTER TABLE event DROP created_at, DROP updated_at, CHANGE datetime datetime VARCHAR(255) NOT NULL');
    $this->addSql('ALTER TABLE produit DROP created_at, DROP updated_at');
    $this->addSql('ALTER TABLE user CHANGE created_at created_at DATETIME DEFAULT NULL');
}

}
