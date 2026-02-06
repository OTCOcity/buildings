<?php

use yii\db\Migration;

class m260206_190000_create_b_buildings_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('b_buildings', [
            'id' => $this->primaryKey(),
            'source_id' => $this->integer()->notNull()->defaultValue(0),
            'thread_id' => $this->integer()->notNull()->defaultValue(0),
            'block_id' => $this->integer()->notNull()->defaultValue(0),
            'block_key' => $this->string(255)->notNull()->defaultValue(''),
            'sort' => $this->integer()->notNull()->defaultValue(0),
            'visible' => $this->boolean()->notNull()->defaultValue(1),
            'lang' => $this->string(6)->notNull()->defaultValue('ru'),
            'name' => $this->string(255)->notNull()->defaultValue(''),
            'link' => $this->string(255)->notNull()->defaultValue(''),
            'mortgage_size' => $this->string(255)->notNull()->defaultValue(''),
            'payment_amount' => $this->string(255)->notNull()->defaultValue(''),
            'purchase_date' => $this->integer()->notNull()->defaultValue(0),
            'payment_date' => $this->integer()->notNull()->defaultValue(0),
            'next_insurance_date' => $this->integer()->notNull()->defaultValue(0),
            'files' => $this->text(),
            'description' => $this->text(),
            'history' => $this->text(),
        ]);

        $this->createIndex('idx-b_buildings-thread_id', 'b_buildings', 'thread_id');
        $this->createIndex('idx-b_buildings-block_id', 'b_buildings', 'block_id');
        $this->createIndex('idx-b_buildings-block_key', 'b_buildings', 'block_key');
        $this->createIndex('idx-b_buildings-source_id', 'b_buildings', 'source_id');
        $this->createIndex('idx-b_buildings-lang', 'b_buildings', 'lang');
    }

    public function safeDown()
    {
        $this->dropTable('b_buildings');
    }
}
