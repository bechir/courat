<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210509053911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE app_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE article_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE classe_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE course_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE day_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE document_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE document_category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE planning_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE resource_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE subject_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_role_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE video_source_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE app_user (id INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9F85E0677 ON app_user (username)');
        $this->addSql('CREATE TABLE article (id INT NOT NULL, title VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, filename VARCHAR(255) DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, slug VARCHAR(255) NOT NULL, title_ar VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE classe (id INT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE classe_subject (classe_id INT NOT NULL, subject_id INT NOT NULL, PRIMARY KEY(classe_id, subject_id))');
        $this->addSql('CREATE INDEX IDX_80575E1B8F5EA509 ON classe_subject (classe_id)');
        $this->addSql('CREATE INDEX IDX_80575E1B23EDC87 ON classe_subject (subject_id)');
        $this->addSql('CREATE TABLE course (id INT NOT NULL, class_id INT NOT NULL, subject_id INT NOT NULL, source_id INT NOT NULL, title VARCHAR(255) NOT NULL, video_url VARCHAR(255) DEFAULT NULL, added_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, published_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, start_time TIME(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_169E6FB9EA000B10 ON course (class_id)');
        $this->addSql('CREATE INDEX IDX_169E6FB923EDC87 ON course (subject_id)');
        $this->addSql('CREATE INDEX IDX_169E6FB9953C1C61 ON course (source_id)');
        $this->addSql('CREATE TABLE day (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE document (id INT NOT NULL, subject_id INT NOT NULL, classe_id INT NOT NULL, category_id INT NOT NULL, title VARCHAR(255) NOT NULL, path VARCHAR(255) DEFAULT NULL, size VARCHAR(255) DEFAULT NULL, client_ip VARCHAR(255) DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, file_url VARCHAR(255) DEFAULT NULL, enabled BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D8698A7623EDC87 ON document (subject_id)');
        $this->addSql('CREATE INDEX IDX_D8698A768F5EA509 ON document (classe_id)');
        $this->addSql('CREATE INDEX IDX_D8698A7612469DE2 ON document (category_id)');
        $this->addSql('CREATE TABLE document_category (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE planning (id INT NOT NULL, day_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D499BFF69C24126 ON planning (day_id)');
        $this->addSql('CREATE TABLE planning_classe (planning_id INT NOT NULL, classe_id INT NOT NULL, PRIMARY KEY(planning_id, classe_id))');
        $this->addSql('CREATE INDEX IDX_EFA69DF93D865311 ON planning_classe (planning_id)');
        $this->addSql('CREATE INDEX IDX_EFA69DF98F5EA509 ON planning_classe (classe_id)');
        $this->addSql('CREATE TABLE planning_subject (planning_id INT NOT NULL, subject_id INT NOT NULL, PRIMARY KEY(planning_id, subject_id))');
        $this->addSql('CREATE INDEX IDX_26A363913D865311 ON planning_subject (planning_id)');
        $this->addSql('CREATE INDEX IDX_26A3639123EDC87 ON planning_subject (subject_id)');
        $this->addSql('CREATE TABLE resource (id INT NOT NULL, title VARCHAR(255) NOT NULL, subtitle VARCHAR(255) DEFAULT NULL, link VARCHAR(255) NOT NULL, filename VARCHAR(255) DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, subtitle_ar VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE subject (id INT NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_role (id INT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE video_source (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE classe_subject ADD CONSTRAINT FK_80575E1B8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE classe_subject ADD CONSTRAINT FK_80575E1B23EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9EA000B10 FOREIGN KEY (class_id) REFERENCES classe (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB923EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9953C1C61 FOREIGN KEY (source_id) REFERENCES video_source (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A7623EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A768F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A7612469DE2 FOREIGN KEY (category_id) REFERENCES document_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF69C24126 FOREIGN KEY (day_id) REFERENCES day (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planning_classe ADD CONSTRAINT FK_EFA69DF93D865311 FOREIGN KEY (planning_id) REFERENCES planning (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planning_classe ADD CONSTRAINT FK_EFA69DF98F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planning_subject ADD CONSTRAINT FK_26A363913D865311 FOREIGN KEY (planning_id) REFERENCES planning (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planning_subject ADD CONSTRAINT FK_26A3639123EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE classe_subject DROP CONSTRAINT FK_80575E1B8F5EA509');
        $this->addSql('ALTER TABLE course DROP CONSTRAINT FK_169E6FB9EA000B10');
        $this->addSql('ALTER TABLE document DROP CONSTRAINT FK_D8698A768F5EA509');
        $this->addSql('ALTER TABLE planning_classe DROP CONSTRAINT FK_EFA69DF98F5EA509');
        $this->addSql('ALTER TABLE planning DROP CONSTRAINT FK_D499BFF69C24126');
        $this->addSql('ALTER TABLE document DROP CONSTRAINT FK_D8698A7612469DE2');
        $this->addSql('ALTER TABLE planning_classe DROP CONSTRAINT FK_EFA69DF93D865311');
        $this->addSql('ALTER TABLE planning_subject DROP CONSTRAINT FK_26A363913D865311');
        $this->addSql('ALTER TABLE classe_subject DROP CONSTRAINT FK_80575E1B23EDC87');
        $this->addSql('ALTER TABLE course DROP CONSTRAINT FK_169E6FB923EDC87');
        $this->addSql('ALTER TABLE document DROP CONSTRAINT FK_D8698A7623EDC87');
        $this->addSql('ALTER TABLE planning_subject DROP CONSTRAINT FK_26A3639123EDC87');
        $this->addSql('ALTER TABLE course DROP CONSTRAINT FK_169E6FB9953C1C61');
        $this->addSql('DROP SEQUENCE app_user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE article_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE classe_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE course_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE day_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE document_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE document_category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE planning_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE resource_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE subject_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_role_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE video_source_id_seq CASCADE');
        $this->addSql('DROP TABLE app_user');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE classe_subject');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE day');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE document_category');
        $this->addSql('DROP TABLE planning');
        $this->addSql('DROP TABLE planning_classe');
        $this->addSql('DROP TABLE planning_subject');
        $this->addSql('DROP TABLE resource');
        $this->addSql('DROP TABLE subject');
        $this->addSql('DROP TABLE user_role');
        $this->addSql('DROP TABLE video_source');
    }
}
