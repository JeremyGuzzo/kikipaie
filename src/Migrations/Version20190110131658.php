<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190110131658 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649541C8FDA');
        $this->addSql('CREATE TABLE budgets (id INT AUTO_INCREMENT NOT NULL, name LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE budget');
        $this->addSql('DROP TABLE entity');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649541C8FDA');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649541C8FDA FOREIGN KEY (group_used_id) REFERENCES budgets (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649541C8FDA');
        $this->addSql('CREATE TABLE budget (id INT AUTO_INCREMENT NOT NULL, name LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE entity (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE budgets');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649541C8FDA');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649541C8FDA FOREIGN KEY (group_used_id) REFERENCES budget (id)');
    }
}
