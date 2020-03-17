<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200317163120 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE class_level (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__course_class AS SELECT id, name FROM course_class');
        $this->addSql('DROP TABLE course_class');
        $this->addSql('CREATE TABLE course_class (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, level_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_4E01E775FB14BA7 FOREIGN KEY (level_id) REFERENCES class_level (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO course_class (id, name) SELECT id, name FROM __temp__course_class');
        $this->addSql('DROP TABLE __temp__course_class');
        $this->addSql('CREATE INDEX IDX_4E01E775FB14BA7 ON course_class (level_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE class_level');
        $this->addSql('DROP INDEX IDX_4E01E775FB14BA7');
        $this->addSql('CREATE TEMPORARY TABLE __temp__course_class AS SELECT id, name FROM course_class');
        $this->addSql('DROP TABLE course_class');
        $this->addSql('CREATE TABLE course_class (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO course_class (id, name) SELECT id, name FROM __temp__course_class');
        $this->addSql('DROP TABLE __temp__course_class');
    }
}
