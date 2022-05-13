<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220512172412 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE location_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE location (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE prediction ADD location_id INT NOT NULL');
        $this->addSql('ALTER TABLE prediction ADD CONSTRAINT FK_36396FC864D218E FOREIGN KEY (location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_36396FC864D218E ON prediction (location_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE prediction DROP CONSTRAINT FK_36396FC864D218E');
        $this->addSql('DROP SEQUENCE location_id_seq CASCADE');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP INDEX IDX_36396FC864D218E');
        $this->addSql('ALTER TABLE prediction DROP location_id');
    }
}
