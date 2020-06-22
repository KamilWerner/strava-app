<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200622020142 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity ADD origin_id BIGINT DEFAULT NULL, ADD high_elevation DOUBLE PRECISION DEFAULT NULL, ADD low_elevation DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD strava_athlete_total_elevation_gain DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity DROP origin_id, DROP high_elevation, DROP low_elevation');
        $this->addSql('ALTER TABLE user DROP strava_athlete_total_elevation_gain');
    }
}
