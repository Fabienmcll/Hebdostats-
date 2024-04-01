<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221219003200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add relation smasheur/tournois';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tournoi CHANGE id_smasheur_vainqueur smasheur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tournoi ADD CONSTRAINT FK_18AFD9DFC8FD8EAB FOREIGN KEY (smasheur_id) REFERENCES smasheur (id)');
        $this->addSql('CREATE INDEX IDX_18AFD9DFC8FD8EAB ON tournoi (smasheur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tournoi DROP FOREIGN KEY FK_18AFD9DFC8FD8EAB');
        $this->addSql('DROP INDEX IDX_18AFD9DFC8FD8EAB ON tournoi');
        $this->addSql('ALTER TABLE tournoi CHANGE smasheur_id id_smasheur_vainqueur INT DEFAULT NULL');
    }
}
