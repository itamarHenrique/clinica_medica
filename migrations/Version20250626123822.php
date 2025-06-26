<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250626123822 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE consulta (id INT AUTO_INCREMENT NOT NULL, paciente_id INT DEFAULT NULL, medico_id INT DEFAULT NULL, data DATE NOT NULL, horario TIME NOT NULL, status VARCHAR(255) NOT NULL, criado_em DATETIME NOT NULL, atualizado_em DATETIME NOT NULL, INDEX IDX_A6FE3FDE7310DAD4 (paciente_id), INDEX IDX_A6FE3FDEA7FB1C0C (medico_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta ADD CONSTRAINT FK_A6FE3FDE7310DAD4 FOREIGN KEY (paciente_id) REFERENCES paciente (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta ADD CONSTRAINT FK_A6FE3FDEA7FB1C0C FOREIGN KEY (medico_id) REFERENCES medico (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta DROP FOREIGN KEY FK_A6FE3FDE7310DAD4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta DROP FOREIGN KEY FK_A6FE3FDEA7FB1C0C
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE consulta
        SQL);
    }
}
