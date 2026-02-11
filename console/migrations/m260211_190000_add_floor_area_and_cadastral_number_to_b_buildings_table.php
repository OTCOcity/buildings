<?php

use yii\db\Migration;

class m260211_190000_add_floor_area_and_cadastral_number_to_b_buildings_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('b_buildings', 'floor', $this->string(255)->notNull()->defaultValue(''));
        $this->addColumn('b_buildings', 'area', $this->string(255)->notNull()->defaultValue(''));
        $this->addColumn('b_buildings', 'cadastral_number', $this->string(255)->notNull()->defaultValue(''));
    }

    public function safeDown()
    {
        $this->dropColumn('b_buildings', 'cadastral_number');
        $this->dropColumn('b_buildings', 'area');
        $this->dropColumn('b_buildings', 'floor');
    }
}
