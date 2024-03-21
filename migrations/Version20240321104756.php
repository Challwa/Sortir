<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240321104756 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sortie CHANGE etats_id etats_id INT UNSIGNED NOT NULL, CHANGE lieux_id lieux_id INT NOT NULL, CHANGE sites_id sites_id INT NOT NULL, CHANGE organisateur_id organisateur_id INT UNSIGNED NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sortie CHANGE etats_id etats_id INT UNSIGNED DEFAULT NULL, CHANGE lieux_id lieux_id INT DEFAULT NULL, CHANGE sites_id sites_id INT DEFAULT NULL, CHANGE organisateur_id organisateur_id INT UNSIGNED DEFAULT NULL');
    }
}
