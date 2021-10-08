<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

# php spark make:migration Users
# to execute
# php spark migrate
class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                        'type' => 'INT',
                        'constraint' => 5,
                        'auto_increment' => true
            ],
            'email' =>[
                        'type' => 'VARCHAR',
                        'constraint' => 100
            ],
            'password' => [
                        'type' => 'VARCHAR',
                        'constraint' => 100 
            ],
            'created_at datetime default current_timestamp',
    'updated_at datetime default current_timestamp on update current_timestamp',
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('users');
        $this->forge->additionalQuery('INSERT INTO `users` (`email`,`password`) VALUES ("admin@gmail.com","$2y$10$cerXA5mB/HjTPEWmsTWaoe1fNQ70lXh6pdTKkj1Bum7LKSV6a1Ope");');
    }

    public function down()
    {
        // $this->forge->dropTable('users');
    }
}
