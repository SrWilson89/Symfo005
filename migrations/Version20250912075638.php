<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250912075638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hilo ADD CONSTRAINT FK_8C95A83DDB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE hilo ADD CONSTRAINT FK_8C95A83D6D5BDFE1 FOREIGN KEY (tarea_id) REFERENCES tareas (id)');
        $this->addSql('ALTER TABLE tareas ADD CONSTRAINT FK_BFE3AB359F5A440B FOREIGN KEY (estado_id) REFERENCES estados (id)');
        $this->addSql('ALTER TABLE tareas ADD CONSTRAINT FK_BFE3AB35DE734E51 FOREIGN KEY (cliente_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE tareas ADD CONSTRAINT FK_BFE3AB35DB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hilo DROP FOREIGN KEY FK_8C95A83DDB38439E');
        $this->addSql('ALTER TABLE hilo DROP FOREIGN KEY FK_8C95A83D6D5BDFE1');
        $this->addSql('ALTER TABLE tareas DROP FOREIGN KEY FK_BFE3AB359F5A440B');
        $this->addSql('ALTER TABLE tareas DROP FOREIGN KEY FK_BFE3AB35DE734E51');
        $this->addSql('ALTER TABLE tareas DROP FOREIGN KEY FK_BFE3AB35DB38439E');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE estados');
        $this->addSql('DROP TABLE hilo');
        $this->addSql('DROP TABLE tareas');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
