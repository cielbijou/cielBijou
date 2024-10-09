<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241009142519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD un_client_id INT NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D72632DFF FOREIGN KEY (un_client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D72632DFF ON commande (un_client_id)');
        $this->addSql('ALTER TABLE ligne_commande ADD un_produit_id INT NOT NULL');
        $this->addSql('ALTER TABLE ligne_commande ADD une_commande_id INT NOT NULL');
        $this->addSql('ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74B6E34096C FOREIGN KEY (un_produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74B11108EE1 FOREIGN KEY (une_commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_3170B74B6E34096C ON ligne_commande (un_produit_id)');
        $this->addSql('CREATE INDEX IDX_3170B74B11108EE1 ON ligne_commande (une_commande_id)');
        $this->addSql('ALTER TABLE produit ADD une_categorie_id INT NOT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC2776D5A8E FOREIGN KEY (une_categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC2776D5A8E ON produit (une_categorie_id)');
        $this->addSql('ALTER TABLE promotion ADD une_categorie_id INT NOT NULL');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD176D5A8E FOREIGN KEY (une_categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_C11D7DD176D5A8E ON promotion (une_categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA db_accessadmin');
        $this->addSql('CREATE SCHEMA db_backupoperator');
        $this->addSql('CREATE SCHEMA db_datareader');
        $this->addSql('CREATE SCHEMA db_datawriter');
        $this->addSql('CREATE SCHEMA db_ddladmin');
        $this->addSql('CREATE SCHEMA db_denydatareader');
        $this->addSql('CREATE SCHEMA db_denydatawriter');
        $this->addSql('CREATE SCHEMA db_owner');
        $this->addSql('CREATE SCHEMA db_securityadmin');
        $this->addSql('CREATE SCHEMA dbo');
        $this->addSql('ALTER TABLE commande DROP CONSTRAINT FK_6EEAA67D72632DFF');
        $this->addSql('DROP INDEX IDX_6EEAA67D72632DFF ON commande');
        $this->addSql('ALTER TABLE commande DROP COLUMN un_client_id');
        $this->addSql('ALTER TABLE ligne_commande DROP CONSTRAINT FK_3170B74B6E34096C');
        $this->addSql('ALTER TABLE ligne_commande DROP CONSTRAINT FK_3170B74B11108EE1');
        $this->addSql('DROP INDEX IDX_3170B74B6E34096C ON ligne_commande');
        $this->addSql('DROP INDEX IDX_3170B74B11108EE1 ON ligne_commande');
        $this->addSql('ALTER TABLE ligne_commande DROP COLUMN un_produit_id');
        $this->addSql('ALTER TABLE ligne_commande DROP COLUMN une_commande_id');
        $this->addSql('ALTER TABLE produit DROP CONSTRAINT FK_29A5EC2776D5A8E');
        $this->addSql('DROP INDEX IDX_29A5EC2776D5A8E ON produit');
        $this->addSql('ALTER TABLE produit DROP COLUMN une_categorie_id');
        $this->addSql('ALTER TABLE promotion DROP CONSTRAINT FK_C11D7DD176D5A8E');
        $this->addSql('DROP INDEX IDX_C11D7DD176D5A8E ON promotion');
        $this->addSql('ALTER TABLE promotion DROP COLUMN une_categorie_id');
    }
}
