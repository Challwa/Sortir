<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240312100211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE participant (id_participant INT UNSIGNED AUTO_INCREMENT NOT NULL, pseudo VARCHAR(30) NOT NULL, nom VARCHAR(30) NOT NULL, prenom VARCHAR(30) NOT NULL, telephone VARCHAR(15) DEFAULT NULL, email VARCHAR(20) NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, roles VARCHAR(255) NOT NULL, actif TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id_participant)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sortie (id_sortie INT AUTO_INCREMENT NOT NULL, id INT UNSIGNED NOT NULL, dateHeureDebut DATETIME NOT NULL, duree DATETIME NOT NULL, dateLimiteInscription DATETIME NOT NULL, nbInscriptionsMax INT NOT NULL, infosSortie LONGTEXT NOT NULL, etat VARCHAR(255) NOT NULL, PRIMARY KEY(id_sortie)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE sortie');
    }
}
