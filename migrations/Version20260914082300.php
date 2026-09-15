<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\DBAL\Platforms\SQLitePlatform;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Renames generic persisted object identity to the Complying-owned target identity.
 */
final class Version20260914082300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rename compliance decision/case object_id columns to target_id.';
    }

    public function up(Schema $schema): void
    {
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof PostgreSQLPlatform
            && !$this->connection->getDatabasePlatform() instanceof SQLitePlatform,
            'Unsupported database platform.',
        );
        $this->addSql('ALTER TABLE compliance_case_queue RENAME COLUMN object_id TO target_id');
        $this->addSql('ALTER TABLE compliance_decision_log RENAME COLUMN object_id TO target_id');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE compliance_case_queue RENAME COLUMN target_id TO object_id');
        $this->addSql('ALTER TABLE compliance_decision_log RENAME COLUMN target_id TO object_id');
    }
}
