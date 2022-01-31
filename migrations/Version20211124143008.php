<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211124143008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE realisation (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, intro LONGTEXT NOT NULL, intro_image_filename VARCHAR(255) DEFAULT NULL, download_link VARCHAR(255) NOT NULL, download_weight VARCHAR(255) DEFAULT NULL, technology_text LONGTEXT NOT NULL, main_text LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE realisation_technology (realisation_id INT NOT NULL, technology_id INT NOT NULL, INDEX IDX_47581877B685E551 (realisation_id), INDEX IDX_475818774235D463 (technology_id), PRIMARY KEY(realisation_id, technology_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE screenshot (id INT AUTO_INCREMENT NOT NULL, realisation_id INT NOT NULL, realisation_sup_id INT NOT NULL, image_filename VARCHAR(255) NOT NULL, INDEX IDX_58991E41B685E551 (realisation_id), INDEX IDX_58991E4194D8FC56 (realisation_sup_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technology (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE realisation_technology ADD CONSTRAINT FK_47581877B685E551 FOREIGN KEY (realisation_id) REFERENCES realisation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE realisation_technology ADD CONSTRAINT FK_475818774235D463 FOREIGN KEY (technology_id) REFERENCES technology (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE screenshot ADD CONSTRAINT FK_58991E41B685E551 FOREIGN KEY (realisation_id) REFERENCES realisation (id)');
        $this->addSql('ALTER TABLE screenshot ADD CONSTRAINT FK_58991E4194D8FC56 FOREIGN KEY (realisation_sup_id) REFERENCES realisation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE realisation_technology DROP FOREIGN KEY FK_47581877B685E551');
        $this->addSql('ALTER TABLE screenshot DROP FOREIGN KEY FK_58991E41B685E551');
        $this->addSql('ALTER TABLE screenshot DROP FOREIGN KEY FK_58991E4194D8FC56');
        $this->addSql('ALTER TABLE realisation_technology DROP FOREIGN KEY FK_475818774235D463');
        $this->addSql('DROP TABLE realisation');
        $this->addSql('DROP TABLE realisation_technology');
        $this->addSql('DROP TABLE screenshot');
        $this->addSql('DROP TABLE technology');
    }
}
