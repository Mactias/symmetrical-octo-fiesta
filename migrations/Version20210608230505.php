<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210608230505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book ADD genre TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE book ALTER isbn DROP NOT NULL');
        $this->addSql('ALTER TABLE book ALTER subject DROP NOT NULL');
        $this->addSql('COMMENT ON COLUMN book.genre IS \'(DC2Type:array)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE book DROP genre');
        $this->addSql('ALTER TABLE book ALTER isbn SET NOT NULL');
        $this->addSql('ALTER TABLE book ALTER subject SET NOT NULL');
    }
}
