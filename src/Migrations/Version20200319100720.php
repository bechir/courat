<?php

declare(strict_types=1);

/*
 * This file is part of the Rim Edu application.
 *
 * By Bechir Ba and contributors
 */

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200319100720 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('sqlite' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE course_class_subject (course_class_id INTEGER NOT NULL, subject_id INTEGER NOT NULL, PRIMARY KEY(course_class_id, subject_id))');
        $this->addSql('CREATE INDEX IDX_FD361D5F43B46646 ON course_class_subject (course_class_id)');
        $this->addSql('CREATE INDEX IDX_FD361D5F23EDC87 ON course_class_subject (subject_id)');
        $this->addSql('CREATE TABLE subject (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, coef INTEGER NOT NULL)');
        $this->addSql('DROP INDEX IDX_4E01E775FB14BA7');
        $this->addSql('CREATE TEMPORARY TABLE __temp__course_class AS SELECT id, level_id, name FROM course_class');
        $this->addSql('DROP TABLE course_class');
        $this->addSql('CREATE TABLE course_class (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, level_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_4E01E775FB14BA7 FOREIGN KEY (level_id) REFERENCES class_level (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO course_class (id, level_id, name) SELECT id, level_id, name FROM __temp__course_class');
        $this->addSql('DROP TABLE __temp__course_class');
        $this->addSql('CREATE INDEX IDX_4E01E775FB14BA7 ON course_class (level_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('sqlite' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE course_class_subject');
        $this->addSql('DROP TABLE subject');
        $this->addSql('DROP INDEX IDX_4E01E775FB14BA7');
        $this->addSql('CREATE TEMPORARY TABLE __temp__course_class AS SELECT id, level_id, name FROM course_class');
        $this->addSql('DROP TABLE course_class');
        $this->addSql('CREATE TABLE course_class (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, level_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO course_class (id, level_id, name) SELECT id, level_id, name FROM __temp__course_class');
        $this->addSql('DROP TABLE __temp__course_class');
        $this->addSql('CREATE INDEX IDX_4E01E775FB14BA7 ON course_class (level_id)');
    }
}
