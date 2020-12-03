<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201203151355 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398788B69E2');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398B96D7824');
        $this->addSql('DROP INDEX IDX_F5299398788B69E2 ON `order`');
        $this->addSql('DROP INDEX IDX_F5299398B96D7824 ON `order`');
        $this->addSql('ALTER TABLE `order` ADD first_adress VARCHAR(230) NOT NULL, ADD second_adress VARCHAR(230) NOT NULL, DROP first_adress_id, DROP second_adress_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `order` ADD first_adress_id INT NOT NULL, ADD second_adress_id INT NOT NULL, DROP first_adress, DROP second_adress');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398788B69E2 FOREIGN KEY (first_adress_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398B96D7824 FOREIGN KEY (second_adress_id) REFERENCES address (id)');
        $this->addSql('CREATE INDEX IDX_F5299398788B69E2 ON `order` (first_adress_id)');
        $this->addSql('CREATE INDEX IDX_F5299398B96D7824 ON `order` (second_adress_id)');
    }
}
