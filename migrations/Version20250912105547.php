<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250912105547 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer ADD direccion VARCHAR(255) NOT NULL, ADD telefono VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, DROP cif, DROP address, DROP postal, DROP location, DROP country, DROP notes, DROP date_add, DROP date_edit, CHANGE name nombre VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE hilo CHANGE date_add date_add DATETIME DEFAULT NULL, CHANGE date_mod date_mod DATETIME DEFAULT NULL, CHANGE notas notas VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE tareas CHANGE notas notas VARCHAR(255) DEFAULT NULL, CHANGE date_add date_add DATETIME DEFAULT NULL, CHANGE date_edit date_edit DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE date_add date_add DATETIME DEFAULT NULL, CHANGE date_edit date_edit DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer ADD name VARCHAR(255) NOT NULL, ADD cif VARCHAR(255) DEFAULT \'NULL\', ADD address VARCHAR(255) DEFAULT \'NULL\', ADD postal VARCHAR(255) DEFAULT \'NULL\', ADD location VARCHAR(255) DEFAULT \'NULL\', ADD country VARCHAR(255) DEFAULT \'NULL\', ADD notes VARCHAR(255) DEFAULT \'NULL\', ADD date_add DATETIME DEFAULT \'NULL\', ADD date_edit DATETIME DEFAULT \'NULL\', DROP nombre, DROP direccion, DROP telefono, DROP email');
        $this->addSql('ALTER TABLE hilo CHANGE date_add date_add DATETIME DEFAULT \'NULL\', CHANGE date_mod date_mod DATETIME DEFAULT \'NULL\', CHANGE notas notas VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\' COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE tareas CHANGE notas notas VARCHAR(255) DEFAULT \'NULL\', CHANGE date_add date_add DATETIME DEFAULT \'NULL\', CHANGE date_edit date_edit DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`, CHANGE date_add date_add DATETIME DEFAULT \'NULL\', CHANGE date_edit date_edit DATETIME DEFAULT \'NULL\'');
    }
}
