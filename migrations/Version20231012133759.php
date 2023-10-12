<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231012133759 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE editeur_article (editeur_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_61D73D073375BD21 (editeur_id), INDEX IDX_61D73D077294869C (article_id), PRIMARY KEY(editeur_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE editeur_article ADD CONSTRAINT FK_61D73D073375BD21 FOREIGN KEY (editeur_id) REFERENCES editeur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE editeur_article ADD CONSTRAINT FK_61D73D077294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE editeur_article DROP FOREIGN KEY FK_61D73D073375BD21');
        $this->addSql('ALTER TABLE editeur_article DROP FOREIGN KEY FK_61D73D077294869C');
        $this->addSql('DROP TABLE editeur_article');
    }
}
