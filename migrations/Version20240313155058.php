<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240313155058 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participant CHANGE email email VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE sortie ADD date_heure_debut DATETIME NOT NULL, ADD date_limite_inscription DATETIME NOT NULL, ADD infos_sortie VARCHAR(255) NOT NULL, DROP dateHeureDebut, DROP dateLimiteInscription, DROP infosSortie, CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE duree duree INT NOT NULL, CHANGE nbInscriptionsMax nb_inscriptions_max INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participant CHANGE email email VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE sortie ADD dateHeureDebut DATETIME NOT NULL, ADD dateLimiteInscription DATETIME NOT NULL, ADD infosSortie LONGTEXT NOT NULL, DROP date_heure_debut, DROP date_limite_inscription, DROP infos_sortie, CHANGE nom nom INT UNSIGNED NOT NULL, CHANGE duree duree DATETIME NOT NULL, CHANGE nb_inscriptions_max nbInscriptionsMax INT NOT NULL');
    }
}
