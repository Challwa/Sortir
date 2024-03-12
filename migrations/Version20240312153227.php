<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240312153227 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lieu DROP id_lieu');
        $this->addSql('ALTER TABLE participant CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE site DROP id_site');
        $this->addSql('ALTER TABLE sortie CHANGE id nom INT UNSIGNED NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lieu ADD id_lieu INT NOT NULL');
        $this->addSql('ALTER TABLE participant CHANGE roles roles VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE site ADD id_site INT NOT NULL');
        $this->addSql('ALTER TABLE sortie CHANGE nom id INT UNSIGNED NOT NULL');
    }
}