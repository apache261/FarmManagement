<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Feeds extends Migration
{
    public function up()
    {

        $this->forge->addField([
            'id' => [
                'type'=> 'INT',
                'constraint' => 5,
                'auto_increment' => true
            ],
            'owner' => [
                'type'=> 'INT',
                'constraint' => 5
            ],
            'type' => [
                'type'=> 'INT',
                'constraint' => 1,
                'default' => 0
            ],
            'name' => [
                'type'=> 'VARCHAR',
                'constraint' => 255
            ],
            'administered' => [
                'type'=> 'VARCHAR',
                'constraint' => 20
            ],
            'created_at datetime default current_timestamp',
    'updated_at datetime default current_timestamp on update current_timestamp',
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('owner','products','id','CASCADE','CASCADE');
        $this->forge->createTable('Feeds');
        $this->forge->additionalQuery('ALTER TABLE Feeds AUTO_INCREMENT = 100'); // custom code
    }

    public function down()
    {
        //
    }
}
