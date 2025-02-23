<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250223215745 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidat (id INT AUTO_INCREMENT NOT NULL, internship_id INT DEFAULT NULL, student_id INT DEFAULT NULL, date_candidature DATE NOT NULL, email VARCHAR(255) NOT NULL, phone_number INT NOT NULL, full_name VARCHAR(255) NOT NULL, result TINYINT(1) NOT NULL, INDEX IDX_6AB5B4717A4A70BE (internship_id), INDEX IDX_6AB5B471CB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE complaint (id INT AUTO_INCREMENT NOT NULL, complaintresponse_id INT DEFAULT NULL, user_id INT DEFAULT NULL, subject VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, message VARCHAR(255) NOT NULL, date_soumission DATE NOT NULL, status VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5F2732B5D3BFA684 (complaintresponse_id), INDEX IDX_5F2732B5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE complaint_response (id INT AUTO_INCREMENT NOT NULL, admin_id INT DEFAULT NULL, response VARCHAR(255) NOT NULL, date_response DATE NOT NULL, email_sender VARCHAR(255) NOT NULL, INDEX IDX_22622279642B8210 (admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, tutor_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, domain VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, price DOUBLE PRECISION DEFAULT NULL, creation_date DATE NOT NULL, INDEX IDX_169E6FB9208F64F1 (tutor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_student (course_id INT NOT NULL, student_id INT NOT NULL, INDEX IDX_BFE0AADF591CC992 (course_id), INDEX IDX_BFE0AADFCB944F1A (student_id), PRIMARY KEY(course_id, student_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, date_event DATE NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE internship (id INT AUTO_INCREMENT NOT NULL, agent_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, company_name VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, duration VARCHAR(255) NOT NULL, requirements VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_10D1B00C3414710B (agent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, user_id INT DEFAULT NULL, nb_places INT NOT NULL, total_price DOUBLE PRECISION NOT NULL, phone_number INT NOT NULL, name VARCHAR(255) NOT NULL, special_request VARCHAR(255) NOT NULL, INDEX IDX_42C8495571F7E88B (event_id), INDEX IDX_42C84955A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ressource (id INT AUTO_INCREMENT NOT NULL, courses_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, format VARCHAR(255) NOT NULL, creation_date DATE NOT NULL, file_path VARCHAR(255) DEFAULT NULL, INDEX IDX_939F4544F9295384 (courses_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, entry_date DATE NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, domain VARCHAR(255) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, company_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_course (user_id INT NOT NULL, course_id INT NOT NULL, INDEX IDX_73CC7484A76ED395 (user_id), INDEX IDX_73CC7484591CC992 (course_id), PRIMARY KEY(user_id, course_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidat ADD CONSTRAINT FK_6AB5B4717A4A70BE FOREIGN KEY (internship_id) REFERENCES internship (id)');
        $this->addSql('ALTER TABLE candidat ADD CONSTRAINT FK_6AB5B471CB944F1A FOREIGN KEY (student_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE complaint ADD CONSTRAINT FK_5F2732B5D3BFA684 FOREIGN KEY (complaintresponse_id) REFERENCES complaint_response (id)');
        $this->addSql('ALTER TABLE complaint ADD CONSTRAINT FK_5F2732B5A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE complaint_response ADD CONSTRAINT FK_22622279642B8210 FOREIGN KEY (admin_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9208F64F1 FOREIGN KEY (tutor_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE course_student ADD CONSTRAINT FK_BFE0AADF591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_student ADD CONSTRAINT FK_BFE0AADFCB944F1A FOREIGN KEY (student_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE internship ADD CONSTRAINT FK_10D1B00C3414710B FOREIGN KEY (agent_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495571F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F4544F9295384 FOREIGN KEY (courses_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE user_course ADD CONSTRAINT FK_73CC7484A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_course ADD CONSTRAINT FK_73CC7484591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidat DROP FOREIGN KEY FK_6AB5B4717A4A70BE');
        $this->addSql('ALTER TABLE candidat DROP FOREIGN KEY FK_6AB5B471CB944F1A');
        $this->addSql('ALTER TABLE complaint DROP FOREIGN KEY FK_5F2732B5D3BFA684');
        $this->addSql('ALTER TABLE complaint DROP FOREIGN KEY FK_5F2732B5A76ED395');
        $this->addSql('ALTER TABLE complaint_response DROP FOREIGN KEY FK_22622279642B8210');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9208F64F1');
        $this->addSql('ALTER TABLE course_student DROP FOREIGN KEY FK_BFE0AADF591CC992');
        $this->addSql('ALTER TABLE course_student DROP FOREIGN KEY FK_BFE0AADFCB944F1A');
        $this->addSql('ALTER TABLE internship DROP FOREIGN KEY FK_10D1B00C3414710B');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495571F7E88B');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('ALTER TABLE ressource DROP FOREIGN KEY FK_939F4544F9295384');
        $this->addSql('ALTER TABLE user_course DROP FOREIGN KEY FK_73CC7484A76ED395');
        $this->addSql('ALTER TABLE user_course DROP FOREIGN KEY FK_73CC7484591CC992');
        $this->addSql('DROP TABLE candidat');
        $this->addSql('DROP TABLE complaint');
        $this->addSql('DROP TABLE complaint_response');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE course_student');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE internship');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE ressource');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_course');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
