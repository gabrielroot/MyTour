<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260111150213 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE checkpoints (id INT AUTO_INCREMENT NOT NULL, trip_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, deleted_by_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, visited_date_time DATETIME NOT NULL, estimated_date_time DATETIME DEFAULT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_37D85177A5BC2E0E (trip_id), INDEX IDX_37D85177B03A8386 (created_by_id), INDEX IDX_37D85177896DBBDE (updated_by_id), INDEX IDX_37D85177C76F1F52 (deleted_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE checkpoints ADD CONSTRAINT FK_37D85177A5BC2E0E FOREIGN KEY (trip_id) REFERENCES trips (id)');
        $this->addSql('ALTER TABLE checkpoints ADD CONSTRAINT FK_37D85177B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE checkpoints ADD CONSTRAINT FK_37D85177896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE checkpoints ADD CONSTRAINT FK_37D85177C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE checkpoints DROP FOREIGN KEY FK_37D85177A5BC2E0E');
        $this->addSql('ALTER TABLE checkpoints DROP FOREIGN KEY FK_37D85177B03A8386');
        $this->addSql('ALTER TABLE checkpoints DROP FOREIGN KEY FK_37D85177896DBBDE');
        $this->addSql('ALTER TABLE checkpoints DROP FOREIGN KEY FK_37D85177C76F1F52');
        $this->addSql('DROP TABLE checkpoints');
    }
}
