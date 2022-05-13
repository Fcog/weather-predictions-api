<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220513172958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE location (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE partner (id INT NOT NULL, name VARCHAR(255) NOT NULL, api_url VARCHAR(255) NOT NULL, format VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE prediction (id INT NOT NULL, location_id INT NOT NULL, partner_id INT NOT NULL, date DATE NOT NULL, time VARCHAR(255) NOT NULL, temperature INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_36396FC864D218E ON prediction (location_id)');
        $this->addSql('CREATE INDEX IDX_36396FC89393F8FE ON prediction (partner_id)');
        $this->addSql('ALTER TABLE prediction ADD CONSTRAINT FK_36396FC864D218E FOREIGN KEY (location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE prediction ADD CONSTRAINT FK_36396FC89393F8FE FOREIGN KEY (partner_id) REFERENCES partner (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE prediction DROP CONSTRAINT FK_36396FC864D218E');
        $this->addSql('ALTER TABLE prediction DROP CONSTRAINT FK_36396FC89393F8FE');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE partner');
        $this->addSql('DROP TABLE prediction');
    }
}
