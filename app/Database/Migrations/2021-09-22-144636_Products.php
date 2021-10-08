<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Products extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' =>[
                'type' => 'INT',
                'constraint' => 5,
                'auto_increment' => true
            ],
            'type' =>[
                'type' => 'INT',
                'constraint' => 1
            ],
            'bday' =>[
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'weight' =>[
                'type' => 'DECIMAL',
                'constraint' => '6,2'
            ],
            'pregnant' =>[
                'type' => 'INT',
                'constraint' => 1
                
            ],
            'due' =>[
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'sold' =>[
                'type' => 'INT',
                'constraint' => 1,
                'default' => 0
            ],
            'created_at datetime default current_timestamp',
    'updated_at datetime default current_timestamp on update current_timestamp',
   
        ]);
        
        $this->forge->addPrimaryKey('id');
        
        $this->forge->createTable('Products');
        $this->forge->additionalQuery('ALTER TABLE Products AUTO_INCREMENT = 1000');

    }

    public function down()
    {
        // $this->forge->dropTable('Products');
    }
}
