<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
	public function up()
	{
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'first_name' => [
                'type' => 'VARCHAR',
                'constraint' => '191'
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'constraint' => '191'
            ],
            'role_id' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '191',
                'unique' => true
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'contact_number' => [
                'type' => 'VARCHAR',
                'constraint' => '16'
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'active' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => 0,
                'default' => 0
            ],
            'created_at' => [
                'type' => 'BIGINT',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'BIGINT',
                'null' => true
            ],
            'deleted_at' => [
                'type' => 'BIGINT',
                'null' => true
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('role_id', 'roles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('users', true);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('users');
	}
}
