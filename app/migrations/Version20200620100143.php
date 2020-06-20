<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200620100143 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD strava_integration_access_token VARCHAR(100) DEFAULT NULL, ADD strava_integration_access_token_expires_at DATETIME DEFAULT NULL, ADD strava_integration_refresh_token VARCHAR(100) DEFAULT NULL, ADD strava_athlete_id INT DEFAULT NULL, ADD strava_athlete_thumb_url VARCHAR(300) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP strava_integration_access_token, DROP strava_integration_access_token_expires_at, DROP strava_integration_refresh_token, DROP strava_athlete_id, DROP strava_athlete_thumb_url');
    }
}
