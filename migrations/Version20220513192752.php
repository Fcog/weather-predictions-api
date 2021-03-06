<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220513192752 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prediction DROP CONSTRAINT fk_36396fc89393f8fe');
        $this->addSql('DROP SEQUENCE partner_id_seq CASCADE');
        $this->addSql('DROP TABLE partner');
        $this->addSql('DROP INDEX idx_36396fc89393f8fe');
        $this->addSql('ALTER TABLE prediction ALTER temperature TYPE INT');
        $this->addSql('ALTER TABLE prediction ALTER temperature DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE partner_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE partner (id INT NOT NULL, name VARCHAR(255) NOT NULL, api_url VARCHAR(255) NOT NULL, format VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE prediction ALTER temperature TYPE INT');
        $this->addSql('ALTER TABLE prediction ALTER temperature DROP DEFAULT');
        $this->addSql('ALTER TABLE prediction ADD CONSTRAINT fk_36396fc89393f8fe FOREIGN KEY (partner_id) REFERENCES partner (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_36396fc89393f8fe ON prediction (partner_id)');
    }
}
