<?php

declare(strict_types=1);

/*
 * This file is part of the COURAT application.
 *
 * (c) Bechir Ba and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200405201548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('sqlite' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE info (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, filename VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME DEFAULT NULL, slug VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE document (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, subject_id INTEGER NOT NULL, classe_id INTEGER NOT NULL, category_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, path VARCHAR(255) DEFAULT NULL, size VARCHAR(255) DEFAULT NULL, client_ip VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, file_url VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_D8698A7623EDC87 ON document (subject_id)');
        $this->addSql('CREATE INDEX IDX_D8698A768F5EA509 ON document (classe_id)');
        $this->addSql('CREATE INDEX IDX_D8698A7612469DE2 ON document (category_id)');
        $this->addSql('CREATE TABLE day (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE document_category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE app_user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9F85E0677 ON app_user (username)');
        $this->addSql('CREATE TABLE classe (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE classe_subject (classe_id INTEGER NOT NULL, subject_id INTEGER NOT NULL, PRIMARY KEY(classe_id, subject_id))');
        $this->addSql('CREATE INDEX IDX_80575E1B8F5EA509 ON classe_subject (classe_id)');
        $this->addSql('CREATE INDEX IDX_80575E1B23EDC87 ON classe_subject (subject_id)');
        $this->addSql('CREATE TABLE course (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, class_id INTEGER NOT NULL, subject_id INTEGER NOT NULL, source_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, video_url VARCHAR(255) DEFAULT NULL, added_at DATETIME NOT NULL, published_at DATETIME NOT NULL, start_time TIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_169E6FB9EA000B10 ON course (class_id)');
        $this->addSql('CREATE INDEX IDX_169E6FB923EDC87 ON course (subject_id)');
        $this->addSql('CREATE INDEX IDX_169E6FB9953C1C61 ON course (source_id)');
        $this->addSql('CREATE TABLE video_source (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE user_role (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE resource (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, subtitle VARCHAR(255) DEFAULT NULL, link VARCHAR(255) NOT NULL, filename VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, subtitle_ar VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE planning (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, day_id INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_D499BFF69C24126 ON planning (day_id)');
        $this->addSql('CREATE TABLE planning_classe (planning_id INTEGER NOT NULL, classe_id INTEGER NOT NULL, PRIMARY KEY(planning_id, classe_id))');
        $this->addSql('CREATE INDEX IDX_EFA69DF93D865311 ON planning_classe (planning_id)');
        $this->addSql('CREATE INDEX IDX_EFA69DF98F5EA509 ON planning_classe (classe_id)');
        $this->addSql('CREATE TABLE planning_subject (planning_id INTEGER NOT NULL, subject_id INTEGER NOT NULL, PRIMARY KEY(planning_id, subject_id))');
        $this->addSql('CREATE INDEX IDX_26A363913D865311 ON planning_subject (planning_id)');
        $this->addSql('CREATE INDEX IDX_26A3639123EDC87 ON planning_subject (subject_id)');
        $this->addSql('CREATE TABLE subject (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, code VARCHAR(255) NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('sqlite' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE info');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE day');
        $this->addSql('DROP TABLE document_category');
        $this->addSql('DROP TABLE app_user');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE classe_subject');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE video_source');
        $this->addSql('DROP TABLE user_role');
        $this->addSql('DROP TABLE resource');
        $this->addSql('DROP TABLE planning');
        $this->addSql('DROP TABLE planning_classe');
        $this->addSql('DROP TABLE planning_subject');
        $this->addSql('DROP TABLE subject');
    }
}
