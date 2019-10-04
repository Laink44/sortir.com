<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191004071617 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX etats_no_etat ON sorties');
        $this->addSql('DROP INDEX organisateur ON sorties');
        $this->addSql('ALTER TABLE sorties DROP etatsortie, DROP lieux_no_lieu, DROP etats_no_etat');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sorties ADD etatsortie INT DEFAULT NULL, ADD lieux_no_lieu INT NOT NULL, ADD etats_no_etat INT NOT NULL');
        $this->addSql('CREATE INDEX etats_no_etat ON sorties (etats_no_etat)');
        $this->addSql('CREATE INDEX organisateur ON sorties (organisateur)');
    }
}
