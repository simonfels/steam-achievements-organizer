<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230802091059 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add completed_at to user_games';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
            ALTER TABLE user_games
            ADD COLUMN completed_at int AFTER game_id;
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
            ALTER TABLE user_games
            DROP COLUMN completed_at;
        SQL);
    }
}
