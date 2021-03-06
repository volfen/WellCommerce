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

/**
 * Migration1396734837
 *
 * This class has been auto-generated
 * by the WellCommerce Console migrate:add command
 */
class Migration1396734837 extends AbstractMigration implements MigrationInterface
{
    public function up()
    {
        if (!$this->getDb()->schema()->hasTable('layout_column')) {
            $this->getDb()->schema()->create('layout_column', function ($table) {
                $table->increments('id');
                $table->integer('layout_theme_id')->unsigned();
                $table->string('page', 255);
                $table->integer('hierarchy')->unsigned()->default(0);
                $table->integer('width')->unsigned()->default(0);
                $table->timestamps();
                $table->foreign('layout_theme_id')->references('id')->on('layout_theme')->onDelete('CASCADE')->onUpdate('NO ACTION');
            });
        }

        if (!$this->getDb()->schema()->hasTable('layout_column_box')) {
            $this->getDb()->schema()->create('layout_column_box', function ($table) {
                $table->increments('id');
                $table->integer('layout_column_id')->unsigned();
                $table->integer('layout_box_id')->unsigned();
                $table->integer('hierarchy')->unsigned()->default(0);
                $table->integer('span')->unsigned()->default(1);
                $table->timestamps();
                $table->foreign('layout_column_id')->references('id')->on('layout_column')->onDelete('CASCADE')->onUpdate('NO ACTION');
                $table->foreign('layout_box_id')->references('id')->on('layout_box')->onDelete('CASCADE')->onUpdate('NO ACTION');
            });
        }
    }

    public function down()
    {

    }
}