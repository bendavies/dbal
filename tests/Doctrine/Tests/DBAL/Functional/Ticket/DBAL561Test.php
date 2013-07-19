<?php

namespace Doctrine\Tests\DBAL\Functional\Ticket;

/**
 * @group DBAL-561
 */
class DBAL561Test extends \Doctrine\Tests\DbalFunctionalTestCase
{
    public function testIssue()
    {
        if ($this->_conn->getDatabasePlatform()->getName() != "postgresql") {
            $this->markTestSkipped('PostgreSQL only test');
        }

        $sm = $this->_conn->getSchemaManager();

        $createTableSQL = "CREATE TABLE usr(contact_count integer NOT NULL DEFAULT 0)";
        $this->_conn->exec($createTableSQL);

        $tableFrom = $sm->listTableDetails('usr');

        $tableTo = new \Doctrine\DBAL\Schema\Table('usr');
        $tableTo->addColumn(
            'contact_count',
            'integer',
            array(
                'length' => null,
                'notnull' => true,
                'platformOptions' =>
                array(
                    'version' => false,
                ),
                'precision' => 0,
                'scale' => 0,
                'default' => null,
                'customSchemaOptions' => array(),
            )
        );

        $c = new \Doctrine\DBAL\Schema\Comparator();
        $diff = $c->diffTable($tableFrom, $tableTo);

        $sql = $this->_conn->getDatabasePlatform()->getAlterTableSQL($diff);

        $this->assertStringEndsNotWith('SET ', $sql[0]);
    }
}