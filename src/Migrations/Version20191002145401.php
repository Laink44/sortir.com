<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191002145401 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX sortie_id ON inscription');
        $this->addSql('DROP INDEX villes_no_ville ON lieux');
        $this->addSql('ALTER TABLE lieux DROP villes_no_ville');
        $this->addSql('ALTER TABLE participants CHANGE username username VARCHAR(50) NOT NULL, CHANGE telephone telephone VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE participants RENAME INDEX username TO UNIQ_71697092F85E0677');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE UNIQUE INDEX sortie_id ON inscription (sortie_id, participant_id)');
        $this->addSql('ALTER TABLE lieux ADD villes_no_ville INT NOT NULL');
        $this->addSql('CREATE INDEX villes_no_ville ON lieux (villes_no_ville)');
        $this->addSql('ALTER TABLE participants CHANGE username username VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE telephone telephone VARCHAR(10) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE participants RENAME INDEX uniq_71697092f85e0677 TO username');
    }
}
