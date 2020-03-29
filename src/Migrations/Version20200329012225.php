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
final class Version20200329012225 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('sqlite' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_3ED5A0738F5EA509');
        $this->addSql('DROP INDEX IDX_3ED5A073591CC992');
        $this->addSql('CREATE TEMPORARY TABLE __temp__classe_course AS SELECT classe_id, course_id FROM classe_course');
        $this->addSql('DROP TABLE classe_course');
        $this->addSql('CREATE TABLE classe_course (classe_id INTEGER NOT NULL, course_id INTEGER NOT NULL, PRIMARY KEY(classe_id, course_id), CONSTRAINT FK_3ED5A0738F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3ED5A073591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO classe_course (classe_id, course_id) SELECT classe_id, course_id FROM __temp__classe_course');
        $this->addSql('DROP TABLE __temp__classe_course');
        $this->addSql('CREATE INDEX IDX_3ED5A0738F5EA509 ON classe_course (classe_id)');
        $this->addSql('CREATE INDEX IDX_3ED5A073591CC992 ON classe_course (course_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__course AS SELECT id, title, video_url, added_at, published_at, start_time FROM course');
        $this->addSql('DROP TABLE course');
        $this->addSql('CREATE TABLE course (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, video_url VARCHAR(255) DEFAULT NULL COLLATE BINARY, added_at DATETIME NOT NULL, start_time TIME DEFAULT NULL, published_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO course (id, title, video_url, added_at, published_at, start_time) SELECT id, title, video_url, added_at, published_at, start_time FROM __temp__course');
        $this->addSql('DROP TABLE __temp__course');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('sqlite' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_3ED5A0738F5EA509');
        $this->addSql('DROP INDEX IDX_3ED5A073591CC992');
        $this->addSql('CREATE TEMPORARY TABLE __temp__classe_course AS SELECT classe_id, course_id FROM classe_course');
        $this->addSql('DROP TABLE classe_course');
        $this->addSql('CREATE TABLE classe_course (classe_id INTEGER NOT NULL, course_id INTEGER NOT NULL, PRIMARY KEY(classe_id, course_id))');
        $this->addSql('INSERT INTO classe_course (classe_id, course_id) SELECT classe_id, course_id FROM __temp__classe_course');
        $this->addSql('DROP TABLE __temp__classe_course');
        $this->addSql('CREATE INDEX IDX_3ED5A0738F5EA509 ON classe_course (classe_id)');
        $this->addSql('CREATE INDEX IDX_3ED5A073591CC992 ON classe_course (course_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__course AS SELECT id, title, video_url, added_at, published_at, start_time FROM course');
        $this->addSql('DROP TABLE course');
        $this->addSql('CREATE TABLE course (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, video_url VARCHAR(255) DEFAULT NULL, added_at DATETIME NOT NULL, start_time TIME DEFAULT NULL, published_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO course (id, title, video_url, added_at, published_at, start_time) SELECT id, title, video_url, added_at, published_at, start_time FROM __temp__course');
        $this->addSql('DROP TABLE __temp__course');
    }
}
