<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * This migration will load the RidePal Single Ride Tickets sample data file: BEtest.sql
 */
class Version20140412124540 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // Generate BEtest.sql data
    		$this->addSql(file_get_contents(__DIR__ . '/BEtest.sql'));

    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        	$this->addSql(file_get_contents(__DIR__ . '/BEdown.sql'));

    }
}
