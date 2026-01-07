<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260107020600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trips (id INT AUTO_INCREMENT NOT NULL, traveler_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, deleted_by_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, capacity INT NOT NULL, date_start DATETIME NOT NULL, date_end DATETIME DEFAULT NULL, price DOUBLE PRECISION NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_AA7370DA59BBE8A3 (traveler_id), INDEX IDX_AA7370DAB03A8386 (created_by_id), INDEX IDX_AA7370DA896DBBDE (updated_by_id), INDEX IDX_AA7370DAC76F1F52 (deleted_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trips ADD CONSTRAINT FK_AA7370DA59BBE8A3 FOREIGN KEY (traveler_id) REFERENCES traveler_users (id)');
        $this->addSql('ALTER TABLE trips ADD CONSTRAINT FK_AA7370DAB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE trips ADD CONSTRAINT FK_AA7370DA896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE trips ADD CONSTRAINT FK_AA7370DAC76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trips DROP FOREIGN KEY FK_AA7370DA59BBE8A3');
        $this->addSql('ALTER TABLE trips DROP FOREIGN KEY FK_AA7370DAB03A8386');
        $this->addSql('ALTER TABLE trips DROP FOREIGN KEY FK_AA7370DA896DBBDE');
        $this->addSql('ALTER TABLE trips DROP FOREIGN KEY FK_AA7370DAC76F1F52');
        $this->addSql('DROP TABLE trips');
    }
}
