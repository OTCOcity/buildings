<?php

use yii\db\Migration;

class m260212_120000_add_rent_cost_to_b_buildings_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('b_buildings', 'rent_cost', $this->string(255)->notNull()->defaultValue(''));
    }

    public function safeDown()
    {
        $this->dropColumn('b_buildings', 'rent_cost');
    }
}
