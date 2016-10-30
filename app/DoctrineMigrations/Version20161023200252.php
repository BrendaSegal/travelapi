<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161023200252 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE trip (id INT AUTO_INCREMENT NOT NULL, arrival_airport_id INT NOT NULL, departure_airport_id INT NOT NULL, passenger_id INT NOT NULL, is_roundtrip TINYINT(1) DEFAULT \'0\' NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_7656F53B7F43E343 (arrival_airport_id), INDEX IDX_7656F53BF631AB5C (departure_airport_id), INDEX IDX_7656F53B4502E565 (passenger_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trips_arrival_flights (trip_id INT NOT NULL, flight_id INT NOT NULL, INDEX IDX_936A4744A5BC2E0E (trip_id), INDEX IDX_936A474491F478C5 (flight_id), PRIMARY KEY(trip_id, flight_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trips_departure_flights (trip_id INT NOT NULL, flight_id INT NOT NULL, INDEX IDX_31613166A5BC2E0E (trip_id), INDEX IDX_3161316691F478C5 (flight_id), PRIMARY KEY(trip_id, flight_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(10) NOT NULL, name VARCHAR(150) NOT NULL, UNIQUE INDEX code_idx (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE airport (id INT AUTO_INCREMENT NOT NULL, region_id INT NOT NULL, country_id INT NOT NULL, name VARCHAR(150) NOT NULL, code VARCHAR(10) NOT NULL, municipality VARCHAR(100) NOT NULL, latitude_degree NUMERIC(10, 0) NOT NULL, longitude_degree NUMERIC(10, 0) NOT NULL, INDEX IDX_7E91F7C298260155 (region_id), INDEX IDX_7E91F7C2F92F3E70 (country_id), UNIQUE INDEX code_idx (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE passenger (id INT AUTO_INCREMENT NOT NULL, citizenship_country_id INT NOT NULL, first_name VARCHAR(150) NOT NULL, last_name VARCHAR(150) NOT NULL, passport_number VARCHAR(20) NOT NULL, passport_expiry DATETIME NOT NULL, phone VARCHAR(20) NOT NULL, email VARCHAR(20) NOT NULL, date_of_birth DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_3BEFE8DD8F6E66E0 (citizenship_country_id), UNIQUE INDEX passport_number_idx (passport_number), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(10) NOT NULL, name VARCHAR(150) NOT NULL, continent VARCHAR(2) NOT NULL, UNIQUE INDEX code_idx (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE flight (id INT AUTO_INCREMENT NOT NULL, arrival_airport_id INT NOT NULL, departure_airport_id INT NOT NULL, tickets_available INT DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_C257E60E7F43E343 (arrival_airport_id), INDEX IDX_C257E60EF631AB5C (departure_airport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53B7F43E343 FOREIGN KEY (arrival_airport_id) REFERENCES airport (id)');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53BF631AB5C FOREIGN KEY (departure_airport_id) REFERENCES airport (id)');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53B4502E565 FOREIGN KEY (passenger_id) REFERENCES passenger (id)');
        $this->addSql('ALTER TABLE trips_arrival_flights ADD CONSTRAINT FK_936A4744A5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id)');
        $this->addSql('ALTER TABLE trips_arrival_flights ADD CONSTRAINT FK_936A474491F478C5 FOREIGN KEY (flight_id) REFERENCES flight (id)');
        $this->addSql('ALTER TABLE trips_departure_flights ADD CONSTRAINT FK_31613166A5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id)');
        $this->addSql('ALTER TABLE trips_departure_flights ADD CONSTRAINT FK_3161316691F478C5 FOREIGN KEY (flight_id) REFERENCES flight (id)');
        $this->addSql('ALTER TABLE airport ADD CONSTRAINT FK_7E91F7C298260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE airport ADD CONSTRAINT FK_7E91F7C2F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE passenger ADD CONSTRAINT FK_3BEFE8DD8F6E66E0 FOREIGN KEY (citizenship_country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE flight ADD CONSTRAINT FK_C257E60E7F43E343 FOREIGN KEY (arrival_airport_id) REFERENCES airport (id)');
        $this->addSql('ALTER TABLE flight ADD CONSTRAINT FK_C257E60EF631AB5C FOREIGN KEY (departure_airport_id) REFERENCES airport (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trips_arrival_flights DROP FOREIGN KEY FK_936A4744A5BC2E0E');
        $this->addSql('ALTER TABLE trips_departure_flights DROP FOREIGN KEY FK_31613166A5BC2E0E');
        $this->addSql('ALTER TABLE airport DROP FOREIGN KEY FK_7E91F7C298260155');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53B7F43E343');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53BF631AB5C');
        $this->addSql('ALTER TABLE flight DROP FOREIGN KEY FK_C257E60E7F43E343');
        $this->addSql('ALTER TABLE flight DROP FOREIGN KEY FK_C257E60EF631AB5C');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53B4502E565');
        $this->addSql('ALTER TABLE airport DROP FOREIGN KEY FK_7E91F7C2F92F3E70');
        $this->addSql('ALTER TABLE passenger DROP FOREIGN KEY FK_3BEFE8DD8F6E66E0');
        $this->addSql('ALTER TABLE trips_arrival_flights DROP FOREIGN KEY FK_936A474491F478C5');
        $this->addSql('ALTER TABLE trips_departure_flights DROP FOREIGN KEY FK_3161316691F478C5');
        $this->addSql('DROP TABLE trip');
        $this->addSql('DROP TABLE trips_arrival_flights');
        $this->addSql('DROP TABLE trips_departure_flights');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE airport');
        $this->addSql('DROP TABLE passenger');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE flight');
    }
}
