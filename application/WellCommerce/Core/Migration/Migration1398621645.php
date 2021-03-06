<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */
namespace WellCommerce\Core\Migration;

use WellCommerce\Core\Migration;

/**
 * Migration1398621645
 *
 * This class has been auto-generated
 * by the WellCommerce Console migrate:add command
 */
class Migration1398621645 extends AbstractMigration implements MigrationInterface
{
    public function up()
    {
        if (!$this->getDb()->schema()->hasTable('user')) {
            $this->getDb()->schema()->create('user', function ($table) {
                $table->increments('id');
                $table->string('first_name', 255);
                $table->string('last_name', 255);
                $table->string('email', 255);
                $table->string('password', 255);
                $table->boolean('active')->default(true);
                $table->boolean('global')->default(true);
                $table->timestamps();
                $table->unique(Array('email'));
            });
        }
    }

    public function down()
    {

    }
}