<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210324192356 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_parent_id INTEGER DEFAULT NULL, content VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_64C19C1B51A1840 ON category (category_parent_id)');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, tutorial_id INTEGER NOT NULL, content VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_9474526CF675F31B ON comment (author_id)');
        $this->addSql('CREATE INDEX IDX_9474526C89366B7B ON comment (tutorial_id)');
        $this->addSql('DROP INDEX IDX_DADD4A251E27F6BF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__answer AS SELECT id, question_id, content, is_correct FROM answer');
        $this->addSql('DROP TABLE answer');
        $this->addSql('CREATE TABLE answer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, question_id INTEGER NOT NULL, content VARCHAR(255) NOT NULL COLLATE BINARY, is_correct BOOLEAN NOT NULL, CONSTRAINT FK_DADD4A251E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO answer (id, question_id, content, is_correct) SELECT id, question_id, content, is_correct FROM __temp__answer');
        $this->addSql('DROP TABLE __temp__answer');
        $this->addSql('CREATE INDEX IDX_DADD4A251E27F6BF ON answer (question_id)');
        $this->addSql('DROP INDEX IDX_DA62921D89366B7B');
        $this->addSql('DROP INDEX IDX_DA62921D6209CB66');
        $this->addSql('CREATE TEMPORARY TABLE __temp__bookmark AS SELECT id, learner_id, tutorial_id, is_bookmarked FROM bookmark');
        $this->addSql('DROP TABLE bookmark');
        $this->addSql('CREATE TABLE bookmark (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, learner_id INTEGER NOT NULL, tutorial_id INTEGER NOT NULL, is_bookmarked BOOLEAN NOT NULL, CONSTRAINT FK_DA62921D6209CB66 FOREIGN KEY (learner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_DA62921D89366B7B FOREIGN KEY (tutorial_id) REFERENCES tutorial (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO bookmark (id, learner_id, tutorial_id, is_bookmarked) SELECT id, learner_id, tutorial_id, is_bookmarked FROM __temp__bookmark');
        $this->addSql('DROP TABLE __temp__bookmark');
        $this->addSql('CREATE INDEX IDX_DA62921D89366B7B ON bookmark (tutorial_id)');
        $this->addSql('CREATE INDEX IDX_DA62921D6209CB66 ON bookmark (learner_id)');
        $this->addSql('DROP INDEX IDX_AC6340B389366B7B');
        $this->addSql('DROP INDEX IDX_AC6340B36209CB66');
        $this->addSql('CREATE TEMPORARY TABLE __temp__like AS SELECT id, learner_id, tutorial_id, is_liked FROM "like"');
        $this->addSql('DROP TABLE "like"');
        $this->addSql('CREATE TABLE "like" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, learner_id INTEGER NOT NULL, tutorial_id INTEGER NOT NULL, is_liked BOOLEAN DEFAULT NULL, CONSTRAINT FK_AC6340B36209CB66 FOREIGN KEY (learner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_AC6340B389366B7B FOREIGN KEY (tutorial_id) REFERENCES tutorial (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO "like" (id, learner_id, tutorial_id, is_liked) SELECT id, learner_id, tutorial_id, is_liked FROM __temp__like');
        $this->addSql('DROP TABLE __temp__like');
        $this->addSql('CREATE INDEX IDX_AC6340B389366B7B ON "like" (tutorial_id)');
        $this->addSql('CREATE INDEX IDX_AC6340B36209CB66 ON "like" (learner_id)');
        $this->addSql('DROP INDEX IDX_B6F7494E89366B7B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__question AS SELECT id, tutorial_id, position, content FROM question');
        $this->addSql('DROP TABLE question');
        $this->addSql('CREATE TABLE question (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, tutorial_id INTEGER NOT NULL, position INTEGER NOT NULL, content VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_B6F7494E89366B7B FOREIGN KEY (tutorial_id) REFERENCES tutorial (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO question (id, tutorial_id, position, content) SELECT id, tutorial_id, position, content FROM __temp__question');
        $this->addSql('DROP TABLE __temp__question');
        $this->addSql('CREATE INDEX IDX_B6F7494E89366B7B ON question (tutorial_id)');
        $this->addSql('DROP INDEX IDX_329937516209CB66');
        $this->addSql('DROP INDEX IDX_3299375189366B7B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__score AS SELECT id, tutorial_id, learner_id, score FROM score');
        $this->addSql('DROP TABLE score');
        $this->addSql('CREATE TABLE score (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, tutorial_id INTEGER NOT NULL, learner_id INTEGER NOT NULL, score DOUBLE PRECISION NOT NULL, CONSTRAINT FK_3299375189366B7B FOREIGN KEY (tutorial_id) REFERENCES tutorial (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_329937516209CB66 FOREIGN KEY (learner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO score (id, tutorial_id, learner_id, score) SELECT id, tutorial_id, learner_id, score FROM __temp__score');
        $this->addSql('DROP TABLE __temp__score');
        $this->addSql('CREATE INDEX IDX_329937516209CB66 ON score (learner_id)');
        $this->addSql('CREATE INDEX IDX_3299375189366B7B ON score (tutorial_id)');
        $this->addSql('DROP INDEX IDX_C66BFFE9F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tutorial AS SELECT id, author_id, title, content, is_published, is_deleted FROM tutorial');
        $this->addSql('DROP TABLE tutorial');
        $this->addSql('CREATE TABLE tutorial (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, content CLOB NOT NULL COLLATE BINARY, is_published BOOLEAN NOT NULL, is_deleted BOOLEAN NOT NULL, CONSTRAINT FK_C66BFFE9F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO tutorial (id, author_id, title, content, is_published, is_deleted) SELECT id, author_id, title, content, is_published, is_deleted FROM __temp__tutorial');
        $this->addSql('DROP TABLE __temp__tutorial');
        $this->addSql('CREATE INDEX IDX_C66BFFE9F675F31B ON tutorial (author_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP INDEX IDX_DADD4A251E27F6BF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__answer AS SELECT id, question_id, content, is_correct FROM answer');
        $this->addSql('DROP TABLE answer');
        $this->addSql('CREATE TABLE answer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, question_id INTEGER NOT NULL, content VARCHAR(255) NOT NULL, is_correct BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO answer (id, question_id, content, is_correct) SELECT id, question_id, content, is_correct FROM __temp__answer');
        $this->addSql('DROP TABLE __temp__answer');
        $this->addSql('CREATE INDEX IDX_DADD4A251E27F6BF ON answer (question_id)');
        $this->addSql('DROP INDEX IDX_DA62921D6209CB66');
        $this->addSql('DROP INDEX IDX_DA62921D89366B7B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__bookmark AS SELECT id, learner_id, tutorial_id, is_bookmarked FROM bookmark');
        $this->addSql('DROP TABLE bookmark');
        $this->addSql('CREATE TABLE bookmark (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, learner_id INTEGER NOT NULL, tutorial_id INTEGER NOT NULL, is_bookmarked BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO bookmark (id, learner_id, tutorial_id, is_bookmarked) SELECT id, learner_id, tutorial_id, is_bookmarked FROM __temp__bookmark');
        $this->addSql('DROP TABLE __temp__bookmark');
        $this->addSql('CREATE INDEX IDX_DA62921D6209CB66 ON bookmark (learner_id)');
        $this->addSql('CREATE INDEX IDX_DA62921D89366B7B ON bookmark (tutorial_id)');
        $this->addSql('DROP INDEX IDX_AC6340B36209CB66');
        $this->addSql('DROP INDEX IDX_AC6340B389366B7B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__like AS SELECT id, learner_id, tutorial_id, is_liked FROM "like"');
        $this->addSql('DROP TABLE "like"');
        $this->addSql('CREATE TABLE "like" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, learner_id INTEGER NOT NULL, tutorial_id INTEGER NOT NULL, is_liked BOOLEAN DEFAULT NULL)');
        $this->addSql('INSERT INTO "like" (id, learner_id, tutorial_id, is_liked) SELECT id, learner_id, tutorial_id, is_liked FROM __temp__like');
        $this->addSql('DROP TABLE __temp__like');
        $this->addSql('CREATE INDEX IDX_AC6340B36209CB66 ON "like" (learner_id)');
        $this->addSql('CREATE INDEX IDX_AC6340B389366B7B ON "like" (tutorial_id)');
        $this->addSql('DROP INDEX IDX_B6F7494E89366B7B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__question AS SELECT id, tutorial_id, position, content FROM question');
        $this->addSql('DROP TABLE question');
        $this->addSql('CREATE TABLE question (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, tutorial_id INTEGER NOT NULL, position INTEGER NOT NULL, content VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO question (id, tutorial_id, position, content) SELECT id, tutorial_id, position, content FROM __temp__question');
        $this->addSql('DROP TABLE __temp__question');
        $this->addSql('CREATE INDEX IDX_B6F7494E89366B7B ON question (tutorial_id)');
        $this->addSql('DROP INDEX IDX_3299375189366B7B');
        $this->addSql('DROP INDEX IDX_329937516209CB66');
        $this->addSql('CREATE TEMPORARY TABLE __temp__score AS SELECT id, tutorial_id, learner_id, score FROM score');
        $this->addSql('DROP TABLE score');
        $this->addSql('CREATE TABLE score (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, tutorial_id INTEGER NOT NULL, learner_id INTEGER NOT NULL, score DOUBLE PRECISION NOT NULL)');
        $this->addSql('INSERT INTO score (id, tutorial_id, learner_id, score) SELECT id, tutorial_id, learner_id, score FROM __temp__score');
        $this->addSql('DROP TABLE __temp__score');
        $this->addSql('CREATE INDEX IDX_3299375189366B7B ON score (tutorial_id)');
        $this->addSql('CREATE INDEX IDX_329937516209CB66 ON score (learner_id)');
        $this->addSql('DROP INDEX IDX_C66BFFE9F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tutorial AS SELECT id, author_id, title, content, is_published, is_deleted FROM tutorial');
        $this->addSql('DROP TABLE tutorial');
        $this->addSql('CREATE TABLE tutorial (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, content CLOB NOT NULL, is_published BOOLEAN NOT NULL, is_deleted BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO tutorial (id, author_id, title, content, is_published, is_deleted) SELECT id, author_id, title, content, is_published, is_deleted FROM __temp__tutorial');
        $this->addSql('DROP TABLE __temp__tutorial');
        $this->addSql('CREATE INDEX IDX_C66BFFE9F675F31B ON tutorial (author_id)');
    }
}
