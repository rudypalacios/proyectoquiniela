<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221002023313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bet (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, score_1 INT NOT NULL, score_2 INT NOT NULL, INDEX IDX_FBF0EC9BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invitation (id INT AUTO_INCREMENT NOT NULL, sender_id INT NOT NULL, recipient_id INT NOT NULL, token VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_F11D61A2F624B39D (sender_id), INDEX IDX_F11D61A2E92F8F78 (recipient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE league (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, pool DOUBLE PRECISION NOT NULL, create_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expiration_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_3EB4C3187E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE league_member (id INT AUTO_INCREMENT NOT NULL, league_id INT NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_BF29820E58AFC4DE (league_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE league_team (id INT AUTO_INCREMENT NOT NULL, league_id INT NOT NULL, team_1_id INT NOT NULL, team_2_id INT NOT NULL, INDEX IDX_2E3F061E58AFC4DE (league_id), INDEX IDX_2E3F061E2132A881 (team_1_id), INDEX IDX_2E3F061E3387076F (team_2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bet ADD CONSTRAINT FK_FBF0EC9BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A2F624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A2E92F8F78 FOREIGN KEY (recipient_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE league ADD CONSTRAINT FK_3EB4C3187E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE league_member ADD CONSTRAINT FK_BF29820E58AFC4DE FOREIGN KEY (league_id) REFERENCES league (id)');
        $this->addSql('ALTER TABLE league_team ADD CONSTRAINT FK_2E3F061E58AFC4DE FOREIGN KEY (league_id) REFERENCES league (id)');
        $this->addSql('ALTER TABLE league_team ADD CONSTRAINT FK_2E3F061E2132A881 FOREIGN KEY (team_1_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE league_team ADD CONSTRAINT FK_2E3F061E3387076F FOREIGN KEY (team_2_id) REFERENCES team (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE league_member DROP FOREIGN KEY FK_BF29820E58AFC4DE');
        $this->addSql('ALTER TABLE league_team DROP FOREIGN KEY FK_2E3F061E58AFC4DE');
        $this->addSql('ALTER TABLE league_team DROP FOREIGN KEY FK_2E3F061E2132A881');
        $this->addSql('ALTER TABLE league_team DROP FOREIGN KEY FK_2E3F061E3387076F');
        $this->addSql('DROP TABLE bet');
        $this->addSql('DROP TABLE invitation');
        $this->addSql('DROP TABLE league');
        $this->addSql('DROP TABLE league_member');
        $this->addSql('DROP TABLE league_team');
        $this->addSql('DROP TABLE team');
    }
}
