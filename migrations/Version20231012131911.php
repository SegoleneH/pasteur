<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231012131911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE praticien_metier (praticien_id INT NOT NULL, metier_id INT NOT NULL, INDEX IDX_41CD21352391866B (praticien_id), INDEX IDX_41CD2135ED16FA20 (metier_id), PRIMARY KEY(praticien_id, metier_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE praticien_metier ADD CONSTRAINT FK_41CD21352391866B FOREIGN KEY (praticien_id) REFERENCES praticien (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE praticien_metier ADD CONSTRAINT FK_41CD2135ED16FA20 FOREIGN KEY (metier_id) REFERENCES metier (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE praticien_metier DROP FOREIGN KEY FK_41CD21352391866B');
        $this->addSql('ALTER TABLE praticien_metier DROP FOREIGN KEY FK_41CD2135ED16FA20');
        $this->addSql('DROP TABLE praticien_metier');
    }
}
