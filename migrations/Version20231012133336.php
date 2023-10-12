<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231012133336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE editeur ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE editeur ADD CONSTRAINT FK_5A747EFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5A747EFA76ED395 ON editeur (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE editeur DROP FOREIGN KEY FK_5A747EFA76ED395');
        $this->addSql('DROP INDEX UNIQ_5A747EFA76ED395 ON editeur');
        $this->addSql('ALTER TABLE editeur DROP user_id');
    }
}
