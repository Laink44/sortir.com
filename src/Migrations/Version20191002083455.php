<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191002083455 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE `etats` DROP `no_etat`; ALTER TABLE `lieux` DROP `no_lieu`; ALTER TABLE `participants` DROP `no_participant`; ALTER TABLE `sites` DROP `no_site`; ALTER TABLE `sorties` DROP `no_sortie`; ALTER TABLE `villes` DROP `no_ville`;');
        $this->addSql('ALTER TABLE etats ADD id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE lieux ADD id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE participants ADD id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE sites ADD id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE sorties ADD id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE villes ADD id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE etats MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE etats DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE etats DROP id');
        $this->addSql('ALTER TABLE lieux MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE lieux DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE lieux DROP id');
        $this->addSql('ALTER TABLE participants MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE participants DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE participants DROP id');
        $this->addSql('ALTER TABLE sites MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE sites DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE sites DROP id');
        $this->addSql('ALTER TABLE sorties MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE sorties DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE sorties DROP id');
        $this->addSql('ALTER TABLE villes MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE villes DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE villes DROP id');
    }
}
