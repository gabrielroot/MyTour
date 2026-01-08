<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260108001519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trips ADD catalog_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trips ADD CONSTRAINT FK_AA7370DACC3C66FC FOREIGN KEY (catalog_id) REFERENCES catalogs (id)');
        $this->addSql('CREATE INDEX IDX_AA7370DACC3C66FC ON trips (catalog_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trips DROP FOREIGN KEY FK_AA7370DACC3C66FC');
        $this->addSql('DROP INDEX IDX_AA7370DACC3C66FC ON trips');
        $this->addSql('ALTER TABLE trips DROP catalog_id');
    }
}
