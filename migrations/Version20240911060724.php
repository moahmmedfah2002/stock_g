<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240911060724 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD ref VARCHAR(200) NOT NULL, ADD nom VARCHAR(255) NOT NULL, ADD categorie VARCHAR(255) NOT NULL, ADD type VARCHAR(255) NOT NULL, ADD zone VARCHAR(255) NOT NULL, ADD nombre INT NOT NULL');
        $this->addSql('ALTER TABLE matiere ADD ref VARCHAR(200) NOT NULL, ADD nom VARCHAR(255) NOT NULL, ADD categorie VARCHAR(255) NOT NULL, ADD type VARCHAR(255) NOT NULL, ADD zone VARCHAR(255) NOT NULL, ADD nombre INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP ref, DROP nom, DROP categorie, DROP type, DROP zone, DROP nombre');
        $this->addSql('ALTER TABLE matiere DROP ref, DROP nom, DROP categorie, DROP type, DROP zone, DROP nombre');
    }
}
