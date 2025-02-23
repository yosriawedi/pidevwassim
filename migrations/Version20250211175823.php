<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250211175823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE course_student (course_id INT NOT NULL, student_id INT NOT NULL, INDEX IDX_BFE0AADF591CC992 (course_id), INDEX IDX_BFE0AADFCB944F1A (student_id), PRIMARY KEY(course_id, student_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course_student ADD CONSTRAINT FK_BFE0AADF591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_student ADD CONSTRAINT FK_BFE0AADFCB944F1A FOREIGN KEY (student_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidat ADD student_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE candidat ADD CONSTRAINT FK_6AB5B471CB944F1A FOREIGN KEY (student_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_6AB5B471CB944F1A ON candidat (student_id)');
        $this->addSql('ALTER TABLE complaint ADD complaintresponse_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE complaint ADD CONSTRAINT FK_5F2732B5D3BFA684 FOREIGN KEY (complaintresponse_id) REFERENCES complaint_response (id)');
        $this->addSql('ALTER TABLE complaint ADD CONSTRAINT FK_5F2732B5A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5F2732B5D3BFA684 ON complaint (complaintresponse_id)');
        $this->addSql('CREATE INDEX IDX_5F2732B5A76ED395 ON complaint (user_id)');
        $this->addSql('ALTER TABLE complaint_response ADD admin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE complaint_response ADD CONSTRAINT FK_22622279642B8210 FOREIGN KEY (admin_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_22622279642B8210 ON complaint_response (admin_id)');
        $this->addSql('ALTER TABLE course ADD tutor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9208F64F1 FOREIGN KEY (tutor_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_169E6FB9208F64F1 ON course (tutor_id)');
        $this->addSql('ALTER TABLE internship ADD agent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE internship ADD CONSTRAINT FK_10D1B00C3414710B FOREIGN KEY (agent_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_10D1B00C3414710B ON internship (agent_id)');
        $this->addSql('ALTER TABLE reservation ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_42C84955A76ED395 ON reservation (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course_student DROP FOREIGN KEY FK_BFE0AADF591CC992');
        $this->addSql('ALTER TABLE course_student DROP FOREIGN KEY FK_BFE0AADFCB944F1A');
        $this->addSql('DROP TABLE course_student');
        $this->addSql('ALTER TABLE candidat DROP FOREIGN KEY FK_6AB5B471CB944F1A');
        $this->addSql('DROP INDEX IDX_6AB5B471CB944F1A ON candidat');
        $this->addSql('ALTER TABLE candidat DROP student_id');
        $this->addSql('ALTER TABLE complaint DROP FOREIGN KEY FK_5F2732B5D3BFA684');
        $this->addSql('ALTER TABLE complaint DROP FOREIGN KEY FK_5F2732B5A76ED395');
        $this->addSql('DROP INDEX UNIQ_5F2732B5D3BFA684 ON complaint');
        $this->addSql('DROP INDEX IDX_5F2732B5A76ED395 ON complaint');
        $this->addSql('ALTER TABLE complaint DROP complaintresponse_id, DROP user_id');
        $this->addSql('ALTER TABLE complaint_response DROP FOREIGN KEY FK_22622279642B8210');
        $this->addSql('DROP INDEX IDX_22622279642B8210 ON complaint_response');
        $this->addSql('ALTER TABLE complaint_response DROP admin_id');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9208F64F1');
        $this->addSql('DROP INDEX IDX_169E6FB9208F64F1 ON course');
        $this->addSql('ALTER TABLE course DROP tutor_id');
        $this->addSql('ALTER TABLE internship DROP FOREIGN KEY FK_10D1B00C3414710B');
        $this->addSql('DROP INDEX IDX_10D1B00C3414710B ON internship');
        $this->addSql('ALTER TABLE internship DROP agent_id');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('DROP INDEX IDX_42C84955A76ED395 ON reservation');
        $this->addSql('ALTER TABLE reservation DROP user_id');
    }
}
