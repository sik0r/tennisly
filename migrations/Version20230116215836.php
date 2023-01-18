<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230116215836 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE player_match_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE team_match_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE player_match (id INT NOT NULL, home_player_id INT NOT NULL, away_player_id INT NOT NULL, league_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C529BE43E7328C9B ON player_match (home_player_id)');
        $this->addSql('CREATE INDEX IDX_C529BE436861DE1 ON player_match (away_player_id)');
        $this->addSql('CREATE INDEX IDX_C529BE4358AFC4DE ON player_match (league_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C529BE4358AFC4DEE7328C9B6861DE1 ON player_match (league_id, home_player_id, away_player_id)');
        $this->addSql('CREATE TABLE team_match (id INT NOT NULL, home_team_id INT NOT NULL, away_team_id INT NOT NULL, league_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BD5D8C459C4C13F6 ON team_match (home_team_id)');
        $this->addSql('CREATE INDEX IDX_BD5D8C4545185D02 ON team_match (away_team_id)');
        $this->addSql('CREATE INDEX IDX_BD5D8C4558AFC4DE ON team_match (league_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BD5D8C4558AFC4DE9C4C13F645185D02 ON team_match (league_id, home_team_id, away_team_id)');
        $this->addSql('ALTER TABLE player_match ADD CONSTRAINT FK_C529BE43E7328C9B FOREIGN KEY (home_player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE player_match ADD CONSTRAINT FK_C529BE436861DE1 FOREIGN KEY (away_player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE player_match ADD CONSTRAINT FK_C529BE4358AFC4DE FOREIGN KEY (league_id) REFERENCES player_league (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE team_match ADD CONSTRAINT FK_BD5D8C459C4C13F6 FOREIGN KEY (home_team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE team_match ADD CONSTRAINT FK_BD5D8C4545185D02 FOREIGN KEY (away_team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE team_match ADD CONSTRAINT FK_BD5D8C4558AFC4DE FOREIGN KEY (league_id) REFERENCES team_league (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE admin ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE player_league ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE player_league ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE team_league ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE team_league ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE player_match_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE team_match_id_seq CASCADE');
        $this->addSql('ALTER TABLE player_match DROP CONSTRAINT FK_C529BE43E7328C9B');
        $this->addSql('ALTER TABLE player_match DROP CONSTRAINT FK_C529BE436861DE1');
        $this->addSql('ALTER TABLE player_match DROP CONSTRAINT FK_C529BE4358AFC4DE');
        $this->addSql('ALTER TABLE team_match DROP CONSTRAINT FK_BD5D8C459C4C13F6');
        $this->addSql('ALTER TABLE team_match DROP CONSTRAINT FK_BD5D8C4545185D02');
        $this->addSql('ALTER TABLE team_match DROP CONSTRAINT FK_BD5D8C4558AFC4DE');
        $this->addSql('DROP TABLE player_match');
        $this->addSql('DROP TABLE team_match');
        $this->addSql('ALTER TABLE admin DROP created_at');
        $this->addSql('ALTER TABLE admin DROP updated_at');
        $this->addSql('ALTER TABLE team_league DROP created_at');
        $this->addSql('ALTER TABLE team_league DROP updated_at');
        $this->addSql('ALTER TABLE player_league DROP created_at');
        $this->addSql('ALTER TABLE player_league DROP updated_at');
    }
}
