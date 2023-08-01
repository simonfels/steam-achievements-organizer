<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230730213429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
            CREATE TABLE achievements (
                id bigint NOT NULL,
                game_id bigint NOT NULL,
                system_name varchar(100) NOT NULL,
                display_name text NOT NULL,
                hidden tinyint NOT NULL,
                percent float,
                description text,
                icon varchar(300) NOT NULL,
                icongray varchar(300) NOT NULL
            ) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_520_ci';
          
            CREATE TABLE games (
                id bigint NOT NULL,
                name varchar(200) NOT NULL
            ) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_520_ci';

            CREATE TABLE users (
                id bigint NOT NULL,
                name varchar(200) NOT NULL,
                steam_url varchar(200) NOT NULL,
                avatar_url varchar(200) NOT NULL
            ) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_520_ci';

            CREATE TABLE user_achievements (
                id bigint NOT NULL,
                user_id bigint NOT NULL,
                achievement_id bigint NOT NULL,
                achieved tinyint NOT NULL,
                unlocked_at int DEFAULT NULL
            ) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_520_ci';

            CREATE TABLE user_games (
                id bigint NOT NULL,
                user_id bigint NOT NULL,
                game_id bigint NOT NULL
            ) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_520_ci';

            ALTER TABLE achievements
            ADD PRIMARY KEY (id),
            ADD UNIQUE KEY index_achievements_on_game_id_and_name (game_id,system_name);

            ALTER TABLE games
            ADD UNIQUE KEY index_games_id (id);

            ALTER TABLE users
            ADD UNIQUE KEY index_users_id (id);

            ALTER TABLE user_achievements
            ADD PRIMARY KEY (id),
            ADD UNIQUE KEY index_user_achievements_user_id_achievement_id (achievement_id,user_id);

            ALTER TABLE user_games
            ADD UNIQUE KEY index_user_games_user_id_game_id (user_id,game_id);

            ALTER TABLE achievements
            MODIFY id int NOT NULL AUTO_INCREMENT;

            ALTER TABLE user_achievements
            MODIFY id bigint NOT NULL AUTO_INCREMENT;
            
            ALTER TABLE user_games
            MODIFY id bigint NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);
          SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql("
            DROP TABLE achievements;
            DROP TABLE games;
            DROP TABLE users;
            DROP TABLE user_achievements;
            DROP TABLE user_games;
        ");
    }
}
