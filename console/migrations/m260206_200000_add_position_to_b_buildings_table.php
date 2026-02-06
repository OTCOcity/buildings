<?php

use yii\db\Migration;

class m260206_200000_add_position_to_b_buildings_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('b_buildings', 'position', $this->string(255)->notNull()->defaultValue(''));
    }

    public function safeDown()
    {
        $this->dropColumn('b_buildings', 'position');
    }
}
