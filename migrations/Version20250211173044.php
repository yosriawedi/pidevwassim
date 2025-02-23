<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250211173044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidat ADD internship_id INT DEFAULT NULL, ADD internships_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE candidat ADD CONSTRAINT FK_6AB5B4717A4A70BE FOREIGN KEY (internship_id) REFERENCES internship (id)');
        $this->addSql('ALTER TABLE candidat ADD CONSTRAINT FK_6AB5B471CBD269DE FOREIGN KEY (internships_id) REFERENCES internship (id)');
        $this->addSql('CREATE INDEX IDX_6AB5B4717A4A70BE ON candidat (internship_id)');
        $this->addSql('CREATE INDEX IDX_6AB5B471CBD269DE ON candidat (internships_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidat DROP FOREIGN KEY FK_6AB5B4717A4A70BE');
        $this->addSql('ALTER TABLE candidat DROP FOREIGN KEY FK_6AB5B471CBD269DE');
        $this->addSql('DROP INDEX IDX_6AB5B4717A4A70BE ON candidat');
        $this->addSql('DROP INDEX IDX_6AB5B471CBD269DE ON candidat');
        $this->addSql('ALTER TABLE candidat DROP internship_id, DROP internships_id');
    }
}
