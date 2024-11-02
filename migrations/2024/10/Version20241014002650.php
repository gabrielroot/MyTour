<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241014002650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('
            CREATE TABLE companies (
                id INT AUTO_INCREMENT NOT NULL, 
                name VARCHAR(255) NOT NULL, 
                fantasy_name VARCHAR(255) NOT NULL, 
                cnpj VARCHAR(14) DEFAULT NULL, 
                created_by_id INT DEFAULT NULL, 
                updated_by_id INT DEFAULT NULL, 
                deleted_by_id INT DEFAULT NULL, 
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, 
                updated_at DATETIME DEFAULT NULL, 
                deleted_at DATETIME DEFAULT NULL, 
                INDEX IDX_8244AA3AB03A8386 (created_by_id), 
                INDEX IDX_8244AA3A896DBBDE (updated_by_id), 
                INDEX IDX_8244AA3AC76F1F52 (deleted_by_id), 
                PRIMARY KEY(id)
           ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE companies ADD CONSTRAINT FK_8244AA3AB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE companies ADD CONSTRAINT FK_8244AA3A896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE companies ADD CONSTRAINT FK_8244AA3AC76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users ADD company_id INT DEFAULT NULL AFTER password');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id)');
        $this->addSql('CREATE INDEX IDX_1483A5E9979B1AD6 ON users (company_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9979B1AD6');
        $this->addSql('ALTER TABLE companies DROP FOREIGN KEY FK_8244AA3AB03A8386');
        $this->addSql('ALTER TABLE companies DROP FOREIGN KEY FK_8244AA3A896DBBDE');
        $this->addSql('ALTER TABLE companies DROP FOREIGN KEY FK_8244AA3AC76F1F52');
        $this->addSql('DROP TABLE companies');
        $this->addSql('DROP INDEX IDX_1483A5E9979B1AD6 ON users');
        $this->addSql('ALTER TABLE users DROP company_id');
    }
}
