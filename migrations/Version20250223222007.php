<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250223222007 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier_course (panier_id INT NOT NULL, course_id INT NOT NULL, INDEX IDX_A3678DA7F77D927C (panier_id), INDEX IDX_A3678DA7591CC992 (course_id), PRIMARY KEY(panier_id, course_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE panier_course ADD CONSTRAINT FK_A3678DA7F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE panier_course ADD CONSTRAINT FK_A3678DA7591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier_course DROP FOREIGN KEY FK_A3678DA7F77D927C');
        $this->addSql('ALTER TABLE panier_course DROP FOREIGN KEY FK_A3678DA7591CC992');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE panier_course');
    }
}
