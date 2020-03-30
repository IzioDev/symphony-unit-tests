<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200212121337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE path ADD start_location_id INT DEFAULT NULL, ADD end_location_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE path ADD CONSTRAINT FK_B548B0F5C3A313A FOREIGN KEY (start_location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE path ADD CONSTRAINT FK_B548B0FC43C7F1 FOREIGN KEY (end_location_id) REFERENCES location (id)');
        $this->addSql('CREATE INDEX IDX_B548B0F5C3A313A ON path (start_location_id)');
        $this->addSql('CREATE INDEX IDX_B548B0FC43C7F1 ON path (end_location_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE path DROP FOREIGN KEY FK_B548B0F5C3A313A');
        $this->addSql('ALTER TABLE path DROP FOREIGN KEY FK_B548B0FC43C7F1');
        $this->addSql('DROP INDEX IDX_B548B0F5C3A313A ON path');
        $this->addSql('DROP INDEX IDX_B548B0FC43C7F1 ON path');
        $this->addSql('ALTER TABLE path DROP start_location_id, DROP end_location_id');
    }
}
