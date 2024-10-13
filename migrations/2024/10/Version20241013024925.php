<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241013024925 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('
            CREATE TABLE catalogs (
                id INT AUTO_INCREMENT NOT NULL, 
                organizer_id INT DEFAULT NULL, 
                title VARCHAR(255) NOT NULL, 
                description LONGTEXT DEFAULT NULL, 
                available TINYINT(1) DEFAULT 1 NOT NULL, 
                price DOUBLE PRECISION NOT NULL, 
                created_by_id INT DEFAULT NULL, 
                updated_by_id INT DEFAULT NULL, 
                deleted_by_id INT DEFAULT NULL, 
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, 
                updated_at DATETIME DEFAULT NULL, 
                deleted_at DATETIME DEFAULT NULL, 
                INDEX IDX_F3AD370A876C4DDA (organizer_id), 
                INDEX IDX_F3AD370AB03A8386 (created_by_id), 
                INDEX IDX_F3AD370A896DBBDE (updated_by_id), 
                INDEX IDX_F3AD370AC76F1F52 (deleted_by_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE catalogs ADD CONSTRAINT FK_F3AD370A876C4DDA FOREIGN KEY (organizer_id) REFERENCES organizer_users (id)');
        $this->addSql('ALTER TABLE catalogs ADD CONSTRAINT FK_F3AD370AB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE catalogs ADD CONSTRAINT FK_F3AD370A896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE catalogs ADD CONSTRAINT FK_F3AD370AC76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE catalogs DROP FOREIGN KEY FK_F3AD370A876C4DDA');
        $this->addSql('ALTER TABLE catalogs DROP FOREIGN KEY FK_F3AD370AB03A8386');
        $this->addSql('ALTER TABLE catalogs DROP FOREIGN KEY FK_F3AD370A896DBBDE');
        $this->addSql('ALTER TABLE catalogs DROP FOREIGN KEY FK_F3AD370AC76F1F52');
        $this->addSql('DROP TABLE catalogs');
    }
}
