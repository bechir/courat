<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200319100958 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE course_class_subject');
        $this->addSql('DROP INDEX IDX_4E01E775FB14BA7');
        $this->addSql('CREATE TEMPORARY TABLE __temp__course_class AS SELECT id, level_id, name FROM course_class');
        $this->addSql('DROP TABLE course_class');
        $this->addSql('CREATE TABLE course_class (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, level_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_4E01E775FB14BA7 FOREIGN KEY (level_id) REFERENCES class_level (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO course_class (id, level_id, name) SELECT id, level_id, name FROM __temp__course_class');
        $this->addSql('DROP TABLE __temp__course_class');
        $this->addSql('CREATE INDEX IDX_4E01E775FB14BA7 ON course_class (level_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__subject AS SELECT id, name, coef FROM subject');
        $this->addSql('DROP TABLE subject');
        $this->addSql('CREATE TABLE subject (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, course_class_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, coef INTEGER NOT NULL, CONSTRAINT FK_FBCE3E7A43B46646 FOREIGN KEY (course_class_id) REFERENCES course_class (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO subject (id, name, coef) SELECT id, name, coef FROM __temp__subject');
        $this->addSql('DROP TABLE __temp__subject');
        $this->addSql('CREATE INDEX IDX_FBCE3E7A43B46646 ON subject (course_class_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE course_class_subject (course_class_id INTEGER NOT NULL, subject_id INTEGER NOT NULL, PRIMARY KEY(course_class_id, subject_id))');
        $this->addSql('CREATE INDEX IDX_FD361D5F23EDC87 ON course_class_subject (subject_id)');
        $this->addSql('CREATE INDEX IDX_FD361D5F43B46646 ON course_class_subject (course_class_id)');
        $this->addSql('DROP INDEX IDX_4E01E775FB14BA7');
        $this->addSql('CREATE TEMPORARY TABLE __temp__course_class AS SELECT id, level_id, name FROM course_class');
        $this->addSql('DROP TABLE course_class');
        $this->addSql('CREATE TABLE course_class (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, level_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO course_class (id, level_id, name) SELECT id, level_id, name FROM __temp__course_class');
        $this->addSql('DROP TABLE __temp__course_class');
        $this->addSql('CREATE INDEX IDX_4E01E775FB14BA7 ON course_class (level_id)');
        $this->addSql('DROP INDEX IDX_FBCE3E7A43B46646');
        $this->addSql('CREATE TEMPORARY TABLE __temp__subject AS SELECT id, name, coef FROM subject');
        $this->addSql('DROP TABLE subject');
        $this->addSql('CREATE TABLE subject (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, coef INTEGER NOT NULL)');
        $this->addSql('INSERT INTO subject (id, name, coef) SELECT id, name, coef FROM __temp__subject');
        $this->addSql('DROP TABLE __temp__subject');
    }
}
