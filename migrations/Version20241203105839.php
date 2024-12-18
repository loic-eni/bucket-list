<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241203105839 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wish ADD author_id INT NOT NULL, DROP author');
        $this->addSql('ALTER TABLE wish ADD CONSTRAINT FK_D7D174C9F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D7D174C9F675F31B ON wish (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wish DROP FOREIGN KEY FK_D7D174C9F675F31B');
        $this->addSql('DROP INDEX IDX_D7D174C9F675F31B ON wish');
        $this->addSql('ALTER TABLE wish ADD author VARCHAR(50) NOT NULL, DROP author_id');
    }
}
