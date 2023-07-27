<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230727110304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_produit DROP FOREIGN KEY FK_DFDF456C8D9F6D38');
        $this->addSql('ALTER TABLE order_produit DROP FOREIGN KEY FK_DFDF456CF347EFB');
        $this->addSql('DROP INDEX `primary` ON order_produit');
        $this->addSql('ALTER TABLE order_produit DROP quantity');
        $this->addSql('ALTER TABLE order_produit ADD CONSTRAINT FK_DFDF456C8D9F6D38 FOREIGN KEY (order_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE order_produit ADD CONSTRAINT FK_DFDF456CF347EFB FOREIGN KEY (produit_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_produit ADD PRIMARY KEY (produit_id, order_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_produit DROP FOREIGN KEY FK_DFDF456CF347EFB');
        $this->addSql('ALTER TABLE order_produit DROP FOREIGN KEY FK_DFDF456C8D9F6D38');
        $this->addSql('DROP INDEX `PRIMARY` ON order_produit');
        $this->addSql('ALTER TABLE order_produit ADD quantity INT NOT NULL');
        $this->addSql('ALTER TABLE order_produit ADD CONSTRAINT FK_DFDF456CF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_produit ADD CONSTRAINT FK_DFDF456C8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_produit ADD PRIMARY KEY (order_id, produit_id)');
    }
}
