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
final class Version20200329200153 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('sqlite' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_169E6FB9EA000B10');
        $this->addSql('DROP INDEX IDX_169E6FB923EDC87');
        $this->addSql('CREATE TEMPORARY TABLE __temp__course AS SELECT id, class_id, subject_id, title, video_url, added_at, published_at, start_time FROM course');
        $this->addSql('DROP TABLE course');
        $this->addSql('CREATE TABLE course (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, class_id INTEGER NOT NULL, subject_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, video_url VARCHAR(255) DEFAULT NULL COLLATE BINARY, added_at DATETIME NOT NULL, published_at DATETIME NOT NULL, start_time TIME DEFAULT NULL, CONSTRAINT FK_169E6FB9EA000B10 FOREIGN KEY (class_id) REFERENCES classe (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_169E6FB923EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO course (id, class_id, subject_id, title, video_url, added_at, published_at, start_time) SELECT id, class_id, subject_id, title, video_url, added_at, published_at, start_time FROM __temp__course');
        $this->addSql('DROP TABLE __temp__course');
        $this->addSql('CREATE INDEX IDX_169E6FB9EA000B10 ON course (class_id)');
        $this->addSql('CREATE INDEX IDX_169E6FB923EDC87 ON course (subject_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__subject AS SELECT id, name FROM subject');
        $this->addSql('DROP TABLE subject');
        $this->addSql('CREATE TABLE subject (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, code VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO subject (id, code) SELECT id, name FROM __temp__subject');
        $this->addSql('DROP TABLE __temp__subject');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('sqlite' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_169E6FB9EA000B10');
        $this->addSql('DROP INDEX IDX_169E6FB923EDC87');
        $this->addSql('CREATE TEMPORARY TABLE __temp__course AS SELECT id, class_id, subject_id, title, video_url, added_at, published_at, start_time FROM course');
        $this->addSql('DROP TABLE course');
        $this->addSql('CREATE TABLE course (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, class_id INTEGER NOT NULL, subject_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, video_url VARCHAR(255) DEFAULT NULL, added_at DATETIME NOT NULL, published_at DATETIME NOT NULL, start_time TIME DEFAULT NULL)');
        $this->addSql('INSERT INTO course (id, class_id, subject_id, title, video_url, added_at, published_at, start_time) SELECT id, class_id, subject_id, title, video_url, added_at, published_at, start_time FROM __temp__course');
        $this->addSql('DROP TABLE __temp__course');
        $this->addSql('CREATE INDEX IDX_169E6FB9EA000B10 ON course (class_id)');
        $this->addSql('CREATE INDEX IDX_169E6FB923EDC87 ON course (subject_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__subject AS SELECT id, code FROM subject');
        $this->addSql('DROP TABLE subject');
        $this->addSql('CREATE TABLE subject (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO subject (id, name) SELECT id, code FROM __temp__subject');
        $this->addSql('DROP TABLE __temp__subject');
    }
}
