<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200402011230 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE resource (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, subtitle VARCHAR(255) DEFAULT NULL, link VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL)');
        $this->addSql('DROP INDEX IDX_80575E1B23EDC87');
        $this->addSql('DROP INDEX IDX_80575E1B8F5EA509');
        $this->addSql('CREATE TEMPORARY TABLE __temp__classe_subject AS SELECT classe_id, subject_id FROM classe_subject');
        $this->addSql('DROP TABLE classe_subject');
        $this->addSql('CREATE TABLE classe_subject (classe_id INTEGER NOT NULL, subject_id INTEGER NOT NULL, PRIMARY KEY(classe_id, subject_id), CONSTRAINT FK_80575E1B8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_80575E1B23EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO classe_subject (classe_id, subject_id) SELECT classe_id, subject_id FROM __temp__classe_subject');
        $this->addSql('DROP TABLE __temp__classe_subject');
        $this->addSql('CREATE INDEX IDX_80575E1B23EDC87 ON classe_subject (subject_id)');
        $this->addSql('CREATE INDEX IDX_80575E1B8F5EA509 ON classe_subject (classe_id)');
        $this->addSql('DROP INDEX IDX_169E6FB923EDC87');
        $this->addSql('DROP INDEX IDX_169E6FB9EA000B10');
        $this->addSql('CREATE TEMPORARY TABLE __temp__course AS SELECT id, class_id, subject_id, title, video_url, added_at, published_at, start_time FROM course');
        $this->addSql('DROP TABLE course');
        $this->addSql('CREATE TABLE course (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, class_id INTEGER NOT NULL, subject_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, video_url VARCHAR(255) DEFAULT NULL COLLATE BINARY, added_at DATETIME NOT NULL, published_at DATETIME NOT NULL, start_time TIME DEFAULT NULL, CONSTRAINT FK_169E6FB9EA000B10 FOREIGN KEY (class_id) REFERENCES classe (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_169E6FB923EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO course (id, class_id, subject_id, title, video_url, added_at, published_at, start_time) SELECT id, class_id, subject_id, title, video_url, added_at, published_at, start_time FROM __temp__course');
        $this->addSql('DROP TABLE __temp__course');
        $this->addSql('CREATE INDEX IDX_169E6FB923EDC87 ON course (subject_id)');
        $this->addSql('CREATE INDEX IDX_169E6FB9EA000B10 ON course (class_id)');
        $this->addSql('DROP INDEX IDX_D499BFF69C24126');
        $this->addSql('CREATE TEMPORARY TABLE __temp__planning AS SELECT id, day_id FROM planning');
        $this->addSql('DROP TABLE planning');
        $this->addSql('CREATE TABLE planning (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, day_id INTEGER NOT NULL, CONSTRAINT FK_D499BFF69C24126 FOREIGN KEY (day_id) REFERENCES day (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO planning (id, day_id) SELECT id, day_id FROM __temp__planning');
        $this->addSql('DROP TABLE __temp__planning');
        $this->addSql('CREATE INDEX IDX_D499BFF69C24126 ON planning (day_id)');
        $this->addSql('DROP INDEX IDX_EFA69DF98F5EA509');
        $this->addSql('DROP INDEX IDX_EFA69DF93D865311');
        $this->addSql('CREATE TEMPORARY TABLE __temp__planning_classe AS SELECT planning_id, classe_id FROM planning_classe');
        $this->addSql('DROP TABLE planning_classe');
        $this->addSql('CREATE TABLE planning_classe (planning_id INTEGER NOT NULL, classe_id INTEGER NOT NULL, PRIMARY KEY(planning_id, classe_id), CONSTRAINT FK_EFA69DF93D865311 FOREIGN KEY (planning_id) REFERENCES planning (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_EFA69DF98F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO planning_classe (planning_id, classe_id) SELECT planning_id, classe_id FROM __temp__planning_classe');
        $this->addSql('DROP TABLE __temp__planning_classe');
        $this->addSql('CREATE INDEX IDX_EFA69DF98F5EA509 ON planning_classe (classe_id)');
        $this->addSql('CREATE INDEX IDX_EFA69DF93D865311 ON planning_classe (planning_id)');
        $this->addSql('DROP INDEX IDX_26A3639123EDC87');
        $this->addSql('DROP INDEX IDX_26A363913D865311');
        $this->addSql('CREATE TEMPORARY TABLE __temp__planning_subject AS SELECT planning_id, subject_id FROM planning_subject');
        $this->addSql('DROP TABLE planning_subject');
        $this->addSql('CREATE TABLE planning_subject (planning_id INTEGER NOT NULL, subject_id INTEGER NOT NULL, PRIMARY KEY(planning_id, subject_id), CONSTRAINT FK_26A363913D865311 FOREIGN KEY (planning_id) REFERENCES planning (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_26A3639123EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO planning_subject (planning_id, subject_id) SELECT planning_id, subject_id FROM __temp__planning_subject');
        $this->addSql('DROP TABLE __temp__planning_subject');
        $this->addSql('CREATE INDEX IDX_26A3639123EDC87 ON planning_subject (subject_id)');
        $this->addSql('CREATE INDEX IDX_26A363913D865311 ON planning_subject (planning_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE resource');
        $this->addSql('DROP INDEX IDX_80575E1B8F5EA509');
        $this->addSql('DROP INDEX IDX_80575E1B23EDC87');
        $this->addSql('CREATE TEMPORARY TABLE __temp__classe_subject AS SELECT classe_id, subject_id FROM classe_subject');
        $this->addSql('DROP TABLE classe_subject');
        $this->addSql('CREATE TABLE classe_subject (classe_id INTEGER NOT NULL, subject_id INTEGER NOT NULL, PRIMARY KEY(classe_id, subject_id))');
        $this->addSql('INSERT INTO classe_subject (classe_id, subject_id) SELECT classe_id, subject_id FROM __temp__classe_subject');
        $this->addSql('DROP TABLE __temp__classe_subject');
        $this->addSql('CREATE INDEX IDX_80575E1B8F5EA509 ON classe_subject (classe_id)');
        $this->addSql('CREATE INDEX IDX_80575E1B23EDC87 ON classe_subject (subject_id)');
        $this->addSql('DROP INDEX IDX_169E6FB9EA000B10');
        $this->addSql('DROP INDEX IDX_169E6FB923EDC87');
        $this->addSql('CREATE TEMPORARY TABLE __temp__course AS SELECT id, class_id, subject_id, title, video_url, added_at, published_at, start_time FROM course');
        $this->addSql('DROP TABLE course');
        $this->addSql('CREATE TABLE course (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, class_id INTEGER NOT NULL, subject_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, video_url VARCHAR(255) DEFAULT NULL, added_at DATETIME NOT NULL, published_at DATETIME NOT NULL, start_time TIME DEFAULT NULL)');
        $this->addSql('INSERT INTO course (id, class_id, subject_id, title, video_url, added_at, published_at, start_time) SELECT id, class_id, subject_id, title, video_url, added_at, published_at, start_time FROM __temp__course');
        $this->addSql('DROP TABLE __temp__course');
        $this->addSql('CREATE INDEX IDX_169E6FB9EA000B10 ON course (class_id)');
        $this->addSql('CREATE INDEX IDX_169E6FB923EDC87 ON course (subject_id)');
        $this->addSql('DROP INDEX IDX_D499BFF69C24126');
        $this->addSql('CREATE TEMPORARY TABLE __temp__planning AS SELECT id, day_id FROM planning');
        $this->addSql('DROP TABLE planning');
        $this->addSql('CREATE TABLE planning (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, day_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO planning (id, day_id) SELECT id, day_id FROM __temp__planning');
        $this->addSql('DROP TABLE __temp__planning');
        $this->addSql('CREATE INDEX IDX_D499BFF69C24126 ON planning (day_id)');
        $this->addSql('DROP INDEX IDX_EFA69DF93D865311');
        $this->addSql('DROP INDEX IDX_EFA69DF98F5EA509');
        $this->addSql('CREATE TEMPORARY TABLE __temp__planning_classe AS SELECT planning_id, classe_id FROM planning_classe');
        $this->addSql('DROP TABLE planning_classe');
        $this->addSql('CREATE TABLE planning_classe (planning_id INTEGER NOT NULL, classe_id INTEGER NOT NULL, PRIMARY KEY(planning_id, classe_id))');
        $this->addSql('INSERT INTO planning_classe (planning_id, classe_id) SELECT planning_id, classe_id FROM __temp__planning_classe');
        $this->addSql('DROP TABLE __temp__planning_classe');
        $this->addSql('CREATE INDEX IDX_EFA69DF93D865311 ON planning_classe (planning_id)');
        $this->addSql('CREATE INDEX IDX_EFA69DF98F5EA509 ON planning_classe (classe_id)');
        $this->addSql('DROP INDEX IDX_26A363913D865311');
        $this->addSql('DROP INDEX IDX_26A3639123EDC87');
        $this->addSql('CREATE TEMPORARY TABLE __temp__planning_subject AS SELECT planning_id, subject_id FROM planning_subject');
        $this->addSql('DROP TABLE planning_subject');
        $this->addSql('CREATE TABLE planning_subject (planning_id INTEGER NOT NULL, subject_id INTEGER NOT NULL, PRIMARY KEY(planning_id, subject_id))');
        $this->addSql('INSERT INTO planning_subject (planning_id, subject_id) SELECT planning_id, subject_id FROM __temp__planning_subject');
        $this->addSql('DROP TABLE __temp__planning_subject');
        $this->addSql('CREATE INDEX IDX_26A363913D865311 ON planning_subject (planning_id)');
        $this->addSql('CREATE INDEX IDX_26A3639123EDC87 ON planning_subject (subject_id)');
    }
}
