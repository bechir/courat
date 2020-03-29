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
final class Version20200328232623 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('sqlite' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__classe AS SELECT id, name FROM classe');
        $this->addSql('DROP TABLE classe');
        $this->addSql('CREATE TABLE classe (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO classe (id, name) SELECT id, name FROM __temp__classe');
        $this->addSql('DROP TABLE __temp__classe');
        $this->addSql('DROP INDEX IDX_3ED5A0738F5EA509');
        $this->addSql('DROP INDEX IDX_3ED5A073591CC992');
        $this->addSql('CREATE TEMPORARY TABLE __temp__classe_course AS SELECT classe_id, course_id FROM classe_course');
        $this->addSql('DROP TABLE classe_course');
        $this->addSql('CREATE TABLE classe_course (classe_id INTEGER NOT NULL, course_id INTEGER NOT NULL, PRIMARY KEY(classe_id, course_id), CONSTRAINT FK_3ED5A0738F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3ED5A073591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO classe_course (classe_id, course_id) SELECT classe_id, course_id FROM __temp__classe_course');
        $this->addSql('DROP TABLE __temp__classe_course');
        $this->addSql('CREATE INDEX IDX_3ED5A0738F5EA509 ON classe_course (classe_id)');
        $this->addSql('CREATE INDEX IDX_3ED5A073591CC992 ON classe_course (course_id)');
        $this->addSql('ALTER TABLE course ADD COLUMN published_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE course ADD COLUMN start_time TIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('sqlite' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('ALTER TABLE classe ADD COLUMN published_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE classe ADD COLUMN start_time TIME DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_3ED5A0738F5EA509');
        $this->addSql('DROP INDEX IDX_3ED5A073591CC992');
        $this->addSql('CREATE TEMPORARY TABLE __temp__classe_course AS SELECT classe_id, course_id FROM classe_course');
        $this->addSql('DROP TABLE classe_course');
        $this->addSql('CREATE TABLE classe_course (classe_id INTEGER NOT NULL, course_id INTEGER NOT NULL, PRIMARY KEY(classe_id, course_id))');
        $this->addSql('INSERT INTO classe_course (classe_id, course_id) SELECT classe_id, course_id FROM __temp__classe_course');
        $this->addSql('DROP TABLE __temp__classe_course');
        $this->addSql('CREATE INDEX IDX_3ED5A0738F5EA509 ON classe_course (classe_id)');
        $this->addSql('CREATE INDEX IDX_3ED5A073591CC992 ON classe_course (course_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__course AS SELECT id, title, video_url, added_at FROM course');
        $this->addSql('DROP TABLE course');
        $this->addSql('CREATE TABLE course (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, video_url VARCHAR(255) DEFAULT NULL, added_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO course (id, title, video_url, added_at) SELECT id, title, video_url, added_at FROM __temp__course');
        $this->addSql('DROP TABLE __temp__course');
    }
}
