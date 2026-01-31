<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220621135322 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient_folder ADD patient_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE patient_folder ADD CONSTRAINT FK_E7ECE0376B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('CREATE INDEX IDX_E7ECE0376B899279 ON patient_folder (patient_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient_folder DROP FOREIGN KEY FK_E7ECE0376B899279');
        $this->addSql('DROP INDEX IDX_E7ECE0376B899279 ON patient_folder');
        $this->addSql('ALTER TABLE patient_folder DROP patient_id');
    }
}
