<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161026005853 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE trips_return_flights (trip_id INT NOT NULL, flight_id INT NOT NULL, INDEX IDX_EEA46C53A5BC2E0E (trip_id), INDEX IDX_EEA46C5391F478C5 (flight_id), PRIMARY KEY(trip_id, flight_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trips_outbound_flights (trip_id INT NOT NULL, flight_id INT NOT NULL, INDEX IDX_3ABA2738A5BC2E0E (trip_id), INDEX IDX_3ABA273891F478C5 (flight_id), PRIMARY KEY(trip_id, flight_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trips_return_flights ADD CONSTRAINT FK_EEA46C53A5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id)');
        $this->addSql('ALTER TABLE trips_return_flights ADD CONSTRAINT FK_EEA46C5391F478C5 FOREIGN KEY (flight_id) REFERENCES flight (id)');
        $this->addSql('ALTER TABLE trips_outbound_flights ADD CONSTRAINT FK_3ABA2738A5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id)');
        $this->addSql('ALTER TABLE trips_outbound_flights ADD CONSTRAINT FK_3ABA273891F478C5 FOREIGN KEY (flight_id) REFERENCES flight (id)');
        $this->addSql('DROP TABLE trips_arrival_flights');
        $this->addSql('DROP TABLE trips_departure_flights');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE trips_arrival_flights (trip_id INT NOT NULL, flight_id INT NOT NULL, INDEX IDX_936A4744A5BC2E0E (trip_id), INDEX IDX_936A474491F478C5 (flight_id), PRIMARY KEY(trip_id, flight_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trips_departure_flights (trip_id INT NOT NULL, flight_id INT NOT NULL, INDEX IDX_31613166A5BC2E0E (trip_id), INDEX IDX_3161316691F478C5 (flight_id), PRIMARY KEY(trip_id, flight_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trips_arrival_flights ADD CONSTRAINT FK_936A474491F478C5 FOREIGN KEY (flight_id) REFERENCES flight (id)');
        $this->addSql('ALTER TABLE trips_arrival_flights ADD CONSTRAINT FK_936A4744A5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id)');
        $this->addSql('ALTER TABLE trips_departure_flights ADD CONSTRAINT FK_3161316691F478C5 FOREIGN KEY (flight_id) REFERENCES flight (id)');
        $this->addSql('ALTER TABLE trips_departure_flights ADD CONSTRAINT FK_31613166A5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id)');
        $this->addSql('DROP TABLE trips_return_flights');
        $this->addSql('DROP TABLE trips_outbound_flights');
    }
}
