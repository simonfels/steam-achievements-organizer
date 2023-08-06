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
                id bigint NOT NULL,
                game_id bigint NOT NULL,
                name text NOT NULL
            ) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci';

            CREATE TABLE tagged_achievements (
                id bigint NOT NULL,
                achievement_id bigint NOT NULL,
                tag_id bigint NOT NULL
            ) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci';

            ALTER TABLE tagged_achievements
            ADD PRIMARY KEY (id),
            ADD UNIQUE KEY index_tagged_achievements_on_achievment_id_and_tag_id (achivement_id,tag_id);

            ALTER TABLE tagged_achievements
            MODIFY id int NOT NULL AUTO_INCREMENT;

            ALTER TABLE tags
            ADD PRIMARY KEY (id);

            ALTER TABLE tags
            MODIFY id int NOT NULL AUTO_INCREMENT;
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
