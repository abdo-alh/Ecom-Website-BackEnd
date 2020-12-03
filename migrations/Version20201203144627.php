<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201203144627 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `order` ADD country_id INT NOT NULL, ADD city_id INT NOT NULL, ADD first_adress_id INT NOT NULL, ADD second_adress_id INT NOT NULL, ADD first_name VARCHAR(120) NOT NULL, ADD last_name VARCHAR(120) NOT NULL, ADD email VARCHAR(120) NOT NULL, ADD phone VARCHAR(20) NOT NULL, ADD postal_code VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993988BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398788B69E2 FOREIGN KEY (first_adress_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398B96D7824 FOREIGN KEY (second_adress_id) REFERENCES address (id)');
        $this->addSql('CREATE INDEX IDX_F5299398F92F3E70 ON `order` (country_id)');
        $this->addSql('CREATE INDEX IDX_F52993988BAC62AF ON `order` (city_id)');
        $this->addSql('CREATE INDEX IDX_F5299398788B69E2 ON `order` (first_adress_id)');
        $this->addSql('CREATE INDEX IDX_F5299398B96D7824 ON `order` (second_adress_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398F92F3E70');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993988BAC62AF');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398788B69E2');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398B96D7824');
        $this->addSql('DROP INDEX IDX_F5299398F92F3E70 ON `order`');
        $this->addSql('DROP INDEX IDX_F52993988BAC62AF ON `order`');
        $this->addSql('DROP INDEX IDX_F5299398788B69E2 ON `order`');
        $this->addSql('DROP INDEX IDX_F5299398B96D7824 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP country_id, DROP city_id, DROP first_adress_id, DROP second_adress_id, DROP first_name, DROP last_name, DROP email, DROP phone, DROP postal_code');
    }
}
