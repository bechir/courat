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
final class Version20200326231617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('sqlite' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_8F87BF965FB14BA7');
        $this->addSql('CREATE TEMPORARY TABLE __temp__classe AS SELECT id, level_id, name FROM classe');
        $this->addSql('DROP TABLE classe');
        $this->addSql('CREATE TABLE classe (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, level_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_8F87BF965FB14BA7 FOREIGN KEY (level_id) REFERENCES class_level (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO classe (id, level_id, name) SELECT id, level_id, name FROM __temp__classe');
        $this->addSql('DROP TABLE __temp__classe');
        $this->addSql('CREATE INDEX IDX_8F87BF965FB14BA7 ON classe (level_id)');
        $this->addSql('DROP INDEX IDX_3ED5A073591CC992');
        $this->addSql('DROP INDEX IDX_3ED5A0738F5EA509');
        $this->addSql('CREATE TEMPORARY TABLE __temp__classe_course AS SELECT classe_id, course_id FROM classe_course');
        $this->addSql('DROP TABLE classe_course');
        $this->addSql('CREATE TABLE classe_course (classe_id INTEGER NOT NULL, course_id INTEGER NOT NULL, PRIMARY KEY(classe_id, course_id), CONSTRAINT FK_3ED5A0738F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3ED5A073591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO classe_course (classe_id, course_id) SELECT classe_id, course_id FROM __temp__classe_course');
        $this->addSql('DROP TABLE __temp__classe_course');
        $this->addSql('CREATE INDEX IDX_3ED5A073591CC992 ON classe_course (course_id)');
        $this->addSql('CREATE INDEX IDX_3ED5A0738F5EA509 ON classe_course (classe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('sqlite' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_8F87BF965FB14BA7');
        $this->addSql('CREATE TEMPORARY TABLE __temp__classe AS SELECT id, level_id, name FROM classe');
        $this->addSql('DROP TABLE classe');
        $this->addSql('CREATE TABLE classe (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, level_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO classe (id, level_id, name) SELECT id, level_id, name FROM __temp__classe');
        $this->addSql('DROP TABLE __temp__classe');
        $this->addSql('CREATE INDEX IDX_8F87BF965FB14BA7 ON classe (level_id)');
        $this->addSql('DROP INDEX IDX_3ED5A0738F5EA509');
        $this->addSql('DROP INDEX IDX_3ED5A073591CC992');
        $this->addSql('CREATE TEMPORARY TABLE __temp__classe_course AS SELECT classe_id, course_id FROM classe_course');
        $this->addSql('DROP TABLE classe_course');
        $this->addSql('CREATE TABLE classe_course (classe_id INTEGER NOT NULL, course_id INTEGER NOT NULL, PRIMARY KEY(classe_id, course_id))');
        $this->addSql('INSERT INTO classe_course (classe_id, course_id) SELECT classe_id, course_id FROM __temp__classe_course');
        $this->addSql('DROP TABLE __temp__classe_course');
        $this->addSql('CREATE INDEX IDX_3ED5A0738F5EA509 ON classe_course (classe_id)');
        $this->addSql('CREATE INDEX IDX_3ED5A073591CC992 ON classe_course (course_id)');
    }
}
