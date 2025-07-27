<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230805230006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add tags';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
            CREATE TABLE tags (
                id bigint NOT NULL AUTO_INCREMENT,
                game_id bigint NOT NULL,
                name varchar(200) NOT NULL,
                PRIMARY KEY (id)
            ) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci';

            CREATE TABLE tagged_achievements (
                id bigint NOT NULL AUTO_INCREMENT,
                achievement_id bigint NOT NULL,
                tag_id bigint NOT NULL,
                PRIMARY KEY (id)
            ) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci';

            ALTER TABLE tagged_achievements
            ADD UNIQUE KEY index_tagged_achievements_on_achievment_id_and_tag_id (achievement_id,tag_id);
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
            DROP TABLE tags;
            DROP TABLE tagged_achievements;
        SQL);
    }
}
