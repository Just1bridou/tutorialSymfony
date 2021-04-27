<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210427161507 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, question_id INTEGER NOT NULL, content VARCHAR(255) NOT NULL, is_correct BOOLEAN NOT NULL)');
        $this->addSql('CREATE INDEX IDX_DADD4A251E27F6BF ON answer (question_id)');
        $this->addSql('CREATE TABLE bookmark (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, learner_id INTEGER NOT NULL, tutorial_id INTEGER NOT NULL, is_bookmarked BOOLEAN NOT NULL)');
        $this->addSql('CREATE INDEX IDX_DA62921D6209CB66 ON bookmark (learner_id)');
        $this->addSql('CREATE INDEX IDX_DA62921D89366B7B ON bookmark (tutorial_id)');
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_parent_id INTEGER DEFAULT NULL, content VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_64C19C1B51A1840 ON category (category_parent_id)');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, tutorial_id INTEGER NOT NULL, content VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_9474526CF675F31B ON comment (author_id)');
        $this->addSql('CREATE INDEX IDX_9474526C89366B7B ON comment (tutorial_id)');
        $this->addSql('CREATE TABLE "like" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, learner_id INTEGER NOT NULL, tutorial_id INTEGER NOT NULL, is_liked BOOLEAN DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_AC6340B36209CB66 ON "like" (learner_id)');
        $this->addSql('CREATE INDEX IDX_AC6340B389366B7B ON "like" (tutorial_id)');
        $this->addSql('CREATE TABLE question (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, tutorial_id INTEGER NOT NULL, position INTEGER NOT NULL, content VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_B6F7494E89366B7B ON question (tutorial_id)');
        $this->addSql('CREATE TABLE score (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, tutorial_id INTEGER NOT NULL, learner_id INTEGER NOT NULL, score DOUBLE PRECISION NOT NULL)');
        $this->addSql('CREATE INDEX IDX_3299375189366B7B ON score (tutorial_id)');
        $this->addSql('CREATE INDEX IDX_329937516209CB66 ON score (learner_id)');
        $this->addSql('CREATE TABLE tutorial (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, category_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, content CLOB NOT NULL, is_published BOOLEAN NOT NULL, is_deleted BOOLEAN NOT NULL, created_at DATETIME NOT NULL, edited_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_C66BFFE9F675F31B ON tutorial (author_id)');
        $this->addSql('CREATE INDEX IDX_C66BFFE912469DE2 ON tutorial (category_id)');
        $this->addSql('CREATE TABLE "user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, zip VARCHAR(15) NOT NULL, address VARCHAR(255) NOT NULL, birthday DATE NOT NULL, is_banned BOOLEAN NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , is_verified BOOLEAN NOT NULL)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE bookmark');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE "like"');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE score');
        $this->addSql('DROP TABLE tutorial');
        $this->addSql('DROP TABLE "user"');
    }
}
