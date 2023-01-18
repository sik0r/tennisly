<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230116201553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE team_league_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE team_league (id INT NOT NULL, season_id INT NOT NULL, name VARCHAR(255) NOT NULL, gender VARCHAR(20) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_48AF84C14EC001D1 ON team_league (season_id)');
        $this->addSql('CREATE TABLE leagues_teams (league_id INT NOT NULL, team_id INT NOT NULL, PRIMARY KEY(league_id, team_id))');
        $this->addSql('CREATE INDEX IDX_DB2AE55A58AFC4DE ON leagues_teams (league_id)');
        $this->addSql('CREATE INDEX IDX_DB2AE55A296CD8AE ON leagues_teams (team_id)');
        $this->addSql('ALTER TABLE team_league ADD CONSTRAINT FK_48AF84C14EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE leagues_teams ADD CONSTRAINT FK_DB2AE55A58AFC4DE FOREIGN KEY (league_id) REFERENCES team_league (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE leagues_teams ADD CONSTRAINT FK_DB2AE55A296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE team_league_id_seq CASCADE');
        $this->addSql('ALTER TABLE team_league DROP CONSTRAINT FK_48AF84C14EC001D1');
        $this->addSql('ALTER TABLE leagues_teams DROP CONSTRAINT FK_DB2AE55A58AFC4DE');
        $this->addSql('ALTER TABLE leagues_teams DROP CONSTRAINT FK_DB2AE55A296CD8AE');
        $this->addSql('DROP TABLE team_league');
        $this->addSql('DROP TABLE leagues_teams');
    }
}
