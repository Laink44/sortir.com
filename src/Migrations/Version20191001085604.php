<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191001085604 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lieux CHANGE nom_lieu nom_lieu VARCHAR(255) NOT NULL, CHANGE rue rue VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE sites CHANGE nom_site nom_site VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE sorties CHANGE nom nom VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE villes CHANGE nom_ville nom_ville VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lieux CHANGE nom_lieu nom_lieu VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE rue rue VARCHAR(30) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE sites CHANGE nom_site nom_site VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE sorties CHANGE nom nom VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE villes CHANGE nom_ville nom_ville VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
