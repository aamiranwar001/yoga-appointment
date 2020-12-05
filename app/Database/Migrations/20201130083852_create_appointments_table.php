<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAppointmentsTable extends Migration
{
	public function up()
	{
	    $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'tutor_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true
            ],
            'student_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
                'null' => true
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => '1024',
                'null' => true
            ],
            'date' => [
                'type' => 'BIGINT'
            ],
            'time_slot' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'status' => [
                'type' => 'ENUM("cancelled", "done", "pending")',
                'default' => 'pending'
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
	    $this->forge->addForeignKey('tutor_id', 'users', 'id', 'CASCADE', 'CASCADE');
	    $this->forge->addForeignKey('student_id', 'users', 'id', 'CASCADE', 'CASCADE');
	    $this->forge->createTable('appointments', true);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('appointments');
	}
}
