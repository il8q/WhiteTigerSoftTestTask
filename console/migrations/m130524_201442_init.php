<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTables($tableOptions);
        $this->generateTestUsers();
        $this->generateTestAccessTokens();
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%access_token}}');
    }

    private function createTables($tableOptions)
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'is_admin' => $this->boolean()->notNull(),
        ], $tableOptions);
        $this->createTable('{{%access_token}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->unique()->notNull(),
            'access_token' => $this->string(32)->notNull()->unique(),
        ], $tableOptions);
        $this->createTable('{{%blog}}', [
            'id' => $this->primaryKey(),
            'access_token' => $this->string(32)->notNull(),
            'text' => $this->text()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    private function generateTestUsers()
    {
        $this->insert('{{%user}}', [
            'id' => '1',
            'username' => 'root',
            'auth_key' => 'S6HPdt9MhhkHIjL-dguWKANwen3-iGnB',
            'password_hash' => '$2y$13$6TZh79uisAffuqflISn6r.VLloknIn8WM3W5LXJ81h2uJM/FrZCW6',// rootroot
            'email' => 'root@root.com',
            'status' => '10',
            'created_at' => '1655982912',
            'updated_at' => '1655982929',
            'verification_token' => 'kIvG5qgNhOIGad5lLef4zWR8d1abvpN-_1655982912',
            'is_admin' => '1',
        ]);
        $this->insert('{{%user}}', [
            'id' => '2',
            'username' => 'test',
            'auth_key' => 'Rw6UAX4AqsUbc6vhnpD9cPkacZ-f9p9P',
            'password_hash' => '$2y$13$MgHCSD5DhkIW8gRW8z1o6.Pw80Npbf0ML3K.6iNVbh/MZk4wRc/H.',// rootroot
            'email' => 'test@test.com',
            'status' => '10',
            'created_at' => '1656056264',
            'updated_at' => '1656070893',
            'verification_token' => '2faQu9spbrc3FrdFtE_9qeuEEWWnlcCx_1656056264',
            'is_admin' => '0',
        ]);
    }

    private function generateTestAccessTokens()
    {
        $this->insert('{{%access_token}}', [
            'id' => '1',
            'user_id' => '1',
            'access_token' => 'VBh9CuhQSQt5b73mIVwdcz83qc66L6uR_1656229889',
        ]);
        $this->insert('{{%access_token}}', [
            'id' => '2',
            'user_id' => '2',
            'access_token' => 'K_or5snpWK9BfEXFZcSjqvHMMzom2102_1656163864',
        ]);
    }
}
