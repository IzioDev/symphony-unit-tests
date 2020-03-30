<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200330115018 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE path (id INT AUTO_INCREMENT NOT NULL, start_location_id INT DEFAULT NULL, end_location_id INT DEFAULT NULL, driver_id INT DEFAULT NULL, seats INT NOT NULL, start_time DATETIME NOT NULL, INDEX IDX_B548B0F5C3A313A (start_location_id), INDEX IDX_B548B0FC43C7F1 (end_location_id), INDEX IDX_B548B0FC3423909 (driver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE path_user (path_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_E0FF5F1ED96C566B (path_id), INDEX IDX_E0FF5F1EA76ED395 (user_id), PRIMARY KEY(path_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, lat DOUBLE PRECISION NOT NULL, lon DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, nick_name VARCHAR(255) NOT NULL, roles JSON NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649A045A5E9 (nick_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE path ADD CONSTRAINT FK_B548B0F5C3A313A FOREIGN KEY (start_location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE path ADD CONSTRAINT FK_B548B0FC43C7F1 FOREIGN KEY (end_location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE path ADD CONSTRAINT FK_B548B0FC3423909 FOREIGN KEY (driver_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE path_user ADD CONSTRAINT FK_E0FF5F1ED96C566B FOREIGN KEY (path_id) REFERENCES path (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE path_user ADD CONSTRAINT FK_E0FF5F1EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE path_user DROP FOREIGN KEY FK_E0FF5F1ED96C566B');
        $this->addSql('ALTER TABLE path DROP FOREIGN KEY FK_B548B0F5C3A313A');
        $this->addSql('ALTER TABLE path DROP FOREIGN KEY FK_B548B0FC43C7F1');
        $this->addSql('ALTER TABLE path DROP FOREIGN KEY FK_B548B0FC3423909');
        $this->addSql('ALTER TABLE path_user DROP FOREIGN KEY FK_E0FF5F1EA76ED395');
        $this->addSql('DROP TABLE path');
        $this->addSql('DROP TABLE path_user');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE user');
    }
}
