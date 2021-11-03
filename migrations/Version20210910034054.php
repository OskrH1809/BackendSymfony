<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210910034054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE servicios_contratados DROP FOREIGN KEY FK_7E7851799F5A440B');
        $this->addSql('DROP INDEX IDX_7E7851799F5A440B ON servicios_contratados');
        $this->addSql('ALTER TABLE servicios_contratados DROP estado_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE servicios_contratados ADD estado_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE servicios_contratados ADD CONSTRAINT FK_7E7851799F5A440B FOREIGN KEY (estado_id) REFERENCES estado (id)');
        $this->addSql('CREATE INDEX IDX_7E7851799F5A440B ON servicios_contratados (estado_id)');
    }
}
