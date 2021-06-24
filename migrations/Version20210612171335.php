<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210612171335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book ADD loaned_by_id INT DEFAULT NULL');
        /* $this->addSql('ALTER TABLE book ADD loan SMALLINT NOT NULL'); */
        $this->addSql('ALTER TABLE book ADD loan SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE book ADD return_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A33149CA1B72 FOREIGN KEY (loaned_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_CBE5A33149CA1B72 ON book (loaned_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE book DROP CONSTRAINT FK_CBE5A33149CA1B72');
        $this->addSql('DROP INDEX IDX_CBE5A33149CA1B72');
        $this->addSql('ALTER TABLE book DROP loaned_by_id');
        $this->addSql('ALTER TABLE book DROP loan');
        $this->addSql('ALTER TABLE book DROP return_date');
    }
}
