<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241009140335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT IDENTITY NOT NULL, libelle_cat NVARCHAR(50) NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE TABLE client (id INT IDENTITY NOT NULL, email NVARCHAR(180) NOT NULL, roles VARCHAR(MAX) NOT NULL, password NVARCHAR(255) NOT NULL, nom NVARCHAR(50) NOT NULL, prenom NVARCHAR(50) NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON client (email) WHERE email IS NOT NULL');
        $this->addSql('EXEC sp_addextendedproperty N\'MS_Description\', N\'(DC2Type:json)\', N\'SCHEMA\', \'dbo\', N\'TABLE\', \'client\', N\'COLUMN\', \'roles\'');
        $this->addSql('CREATE TABLE commande (id INT IDENTITY NOT NULL, date_commande DATE NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE TABLE commentaire (id INT IDENTITY NOT NULL, un_produit_id INT NOT NULL, un_client_id INT NOT NULL, date_commentaire DATE NOT NULL, status_commentaire BIT, contenu_commentaire VARCHAR(MAX) NOT NULL, note_commentaire INT, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_67F068BC6E34096C ON commentaire (un_produit_id)');
        $this->addSql('CREATE INDEX IDX_67F068BC72632DFF ON commentaire (un_client_id)');
        $this->addSql('CREATE TABLE ligne_commande (id INT IDENTITY NOT NULL, quantite INT NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE TABLE produit (id INT IDENTITY NOT NULL, nom_prod NVARCHAR(50) NOT NULL, description NVARCHAR(255) NOT NULL, image_prod NVARCHAR(255), stock_prod INT NOT NULL, prix_prod NUMERIC(5, 2) NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE TABLE promotion (id INT IDENTITY NOT NULL, date_debut_promo DATE NOT NULL, date_fin_promo DATE NOT NULL, remise_promo NUMERIC(3, 2) NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT IDENTITY NOT NULL, body VARCHAR(MAX) NOT NULL, headers VARCHAR(MAX) NOT NULL, queue_name NVARCHAR(190) NOT NULL, created_at DATETIME2(6) NOT NULL, available_at DATETIME2(6) NOT NULL, delivered_at DATETIME2(6), PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('EXEC sp_addextendedproperty N\'MS_Description\', N\'(DC2Type:datetime_immutable)\', N\'SCHEMA\', \'dbo\', N\'TABLE\', \'messenger_messages\', N\'COLUMN\', \'created_at\'');
        $this->addSql('EXEC sp_addextendedproperty N\'MS_Description\', N\'(DC2Type:datetime_immutable)\', N\'SCHEMA\', \'dbo\', N\'TABLE\', \'messenger_messages\', N\'COLUMN\', \'available_at\'');
        $this->addSql('EXEC sp_addextendedproperty N\'MS_Description\', N\'(DC2Type:datetime_immutable)\', N\'SCHEMA\', \'dbo\', N\'TABLE\', \'messenger_messages\', N\'COLUMN\', \'delivered_at\'');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC6E34096C FOREIGN KEY (un_produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC72632DFF FOREIGN KEY (un_client_id) REFERENCES client (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
       
        $this->addSql('DROP TABLE messenger_messages');
    }
}
