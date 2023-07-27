<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230727104958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_produit (order_id INT NOT NULL, produit_id INT NOT NULL,quantity INT NOT NULL, INDEX IDX_DFDF456C8D9F6D38 (order_id), INDEX IDX_DFDF456CF347EFB (produit_id), PRIMARY KEY(order_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_produit ADD CONSTRAINT FK_DFDF456C8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_produit ADD CONSTRAINT FK_DFDF456CF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_produit DROP FOREIGN KEY FK_DFDF456C8D9F6D38');
        $this->addSql('ALTER TABLE order_produit DROP FOREIGN KEY FK_DFDF456CF347EFB');
        $this->addSql('DROP TABLE order_produit');
    }
}
