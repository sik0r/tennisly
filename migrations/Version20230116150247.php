<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230116150247 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE player_league_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE player_league (id INT NOT NULL, season_id INT NOT NULL, name VARCHAR(255) NOT NULL, gender VARCHAR(20) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A1B455C64EC001D1 ON player_league (season_id)');
        $this->addSql('CREATE TABLE leagues_players (league_id INT NOT NULL, player_id INT NOT NULL, PRIMARY KEY(league_id, player_id))');
        $this->addSql('CREATE INDEX IDX_11783BDF58AFC4DE ON leagues_players (league_id)');
        $this->addSql('CREATE INDEX IDX_11783BDF99E6F5DF ON leagues_players (player_id)');
        $this->addSql('ALTER TABLE player_league ADD CONSTRAINT FK_A1B455C64EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE leagues_players ADD CONSTRAINT FK_11783BDF58AFC4DE FOREIGN KEY (league_id) REFERENCES player_league (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE leagues_players ADD CONSTRAINT FK_11783BDF99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE player_league_id_seq CASCADE');
        $this->addSql('ALTER TABLE player_league DROP CONSTRAINT FK_A1B455C64EC001D1');
        $this->addSql('ALTER TABLE leagues_players DROP CONSTRAINT FK_11783BDF58AFC4DE');
        $this->addSql('ALTER TABLE leagues_players DROP CONSTRAINT FK_11783BDF99E6F5DF');
        $this->addSql('DROP TABLE player_league');
        $this->addSql('DROP TABLE leagues_players');
    }
}
