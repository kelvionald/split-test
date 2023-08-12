<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230806102718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE device (id INT AUTO_INCREMENT NOT NULL, token CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE device_experiment_value (id INT AUTO_INCREMENT NOT NULL, device_id INT NOT NULL, experiment_value_id INT NOT NULL, INDEX IDX_6B0DFDDA94A4C7D4 (device_id), INDEX IDX_6B0DFDDACF0DB293 (experiment_value_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experiment (id INT AUTO_INCREMENT NOT NULL, identifier VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experiment_value (id INT AUTO_INCREMENT NOT NULL, experiment_id INT NOT NULL, value VARCHAR(255) NOT NULL, share INT NOT NULL, INDEX IDX_B50B78A0FF444C8 (experiment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE device_experiment_value ADD CONSTRAINT FK_6B0DFDDA94A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id)');
        $this->addSql('ALTER TABLE device_experiment_value ADD CONSTRAINT FK_6B0DFDDACF0DB293 FOREIGN KEY (experiment_value_id) REFERENCES experiment_value (id)');
        $this->addSql('ALTER TABLE experiment_value ADD CONSTRAINT FK_B50B78A0FF444C8 FOREIGN KEY (experiment_id) REFERENCES experiment (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE device_experiment_value DROP FOREIGN KEY FK_6B0DFDDA94A4C7D4');
        $this->addSql('ALTER TABLE device_experiment_value DROP FOREIGN KEY FK_6B0DFDDACF0DB293');
        $this->addSql('ALTER TABLE experiment_value DROP FOREIGN KEY FK_B50B78A0FF444C8');
        $this->addSql('DROP TABLE device');
        $this->addSql('DROP TABLE device_experiment_value');
        $this->addSql('DROP TABLE experiment');
        $this->addSql('DROP TABLE experiment_value');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
