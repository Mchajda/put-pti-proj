<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210419122434 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519B12469DE2');
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519B727ACA70');
        $this->addSql('DROP INDEX IDX_729F519B12469DE2 ON room');
        $this->addSql('DROP INDEX IDX_729F519B727ACA70 ON room');
        $this->addSql('ALTER TABLE room ADD creator_name VARCHAR(255) NOT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, DROP category_id, DROP parent_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE room ADD category_id INT NOT NULL, ADD parent_id INT DEFAULT NULL, DROP creator_name, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519B12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519B727ACA70 FOREIGN KEY (parent_id) REFERENCES room (id)');
        $this->addSql('CREATE INDEX IDX_729F519B12469DE2 ON room (category_id)');
        $this->addSql('CREATE INDEX IDX_729F519B727ACA70 ON room (parent_id)');
    }
}
