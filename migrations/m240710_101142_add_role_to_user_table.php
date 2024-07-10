<?php

use yii\db\Migration;

/**
 * Class m240710_101142_add_role_to_user_table
 */
class m240710_101142_add_role_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Check if the table exists before adding the column
        if ($this->db->schema->getTableSchema('{{%user}}') === null) {
            $this->createTable('{{%user}}', [
                'id' => $this->primaryKey(),
                'username' => $this->string()->notNull()->unique(),
                'email' => $this->string()->notNull()->unique(),
                'password_hash' => $this->string()->notNull(),
                'auth_key' => $this->string(32),
                'password_reset_token' => $this->string(),
                'status' => $this->smallInteger()->notNull()->defaultValue(10),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
                // Add your new column 'role' here
                'role' => $this->string()->notNull()->defaultValue('user'),
            ]);

            // Add indexes for username and email
            $this->createIndex(
                'idx-user-username',
                '{{%user}}',
                'username'
            );

            $this->createIndex(
                'idx-user-email',
                '{{%user}}',
                'email'
            );
        } else {
            // Table exists, so just add the column
            $this->addColumn('{{%user}}', 'role', $this->string()->notNull()->defaultValue('user')->after('password_hash'));
        }
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'role');

        // Optionally, drop the table if it was created in safeUp()
        if ($this->db->schema->getTableSchema('{{%user}}') !== null) {
            $this->dropTable('{{%user}}');
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240710_101142_add_role_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
