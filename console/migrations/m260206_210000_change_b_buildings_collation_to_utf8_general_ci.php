<?php

use yii\db\Migration;

class m260206_210000_change_b_buildings_collation_to_utf8_general_ci extends Migration
{
    public function safeUp()
    {
        $this->execute('ALTER TABLE `b_buildings` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci');
    }

    public function safeDown()
    {
        $this->execute('ALTER TABLE `b_buildings` CONVERT TO CHARACTER SET latin1 COLLATE latin1_swedish_ci');
    }
}
