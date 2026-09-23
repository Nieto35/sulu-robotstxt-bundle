<?php
declare(strict_types=1);

namespace BitExpert\Sulu\RobotstxtBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

final class Version20260923173134 extends AbstractMigration
{
    private const TABLE = 'robotstxt';

    public function getDescription(): string
    {
        return 'Create robotstxt table';
    }

    public function up(Schema $schema): void
    {
        if ($schema->hasTable(self::TABLE)) {
            return;
        }

        $table = $schema->createTable(self::TABLE);
        $table->addColumn('id', Types::INTEGER, ['autoincrement' => true]);
        $table->addColumn('webspace_key', Types::STRING, ['length' => 255]);
        $table->addColumn('content', Types::TEXT, ['notnull' => false]);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['webspace_key']);
    }

    public function down(Schema $schema): void
    {
        if ($schema->hasTable(self::TABLE)) {
            $schema->dropTable(self::TABLE);
        }
    }
}
