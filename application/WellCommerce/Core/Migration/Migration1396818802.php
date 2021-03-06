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
use WellCommerce\Plugin\Layout\Model\LayoutPage;

/**
 * Migration1396818802
 *
 * This class has been auto-generated
 * by the WellCommerce Console migrate:add command
 */
class Migration1396818802 extends AbstractMigration implements MigrationInterface
{
    public function up()
    {
        if (!$this->getDb()->schema()->hasTable('layout_page')) {
            $this->getDb()->schema()->create('layout_page', function ($table) {
                $table->increments('id');
                $table->string('name', 255);
                $table->timestamps();
            });

            LayoutPage::create(['name' => 'HomePage']);
            LayoutPage::create(['name' => 'Contact']);
            LayoutPage::create(['name' => 'Product']);
            LayoutPage::create(['name' => 'Category']);
            LayoutPage::create(['name' => 'Promotions']);
            LayoutPage::create(['name' => 'News']);
            LayoutPage::create(['name' => 'Producer']);
            LayoutPage::create(['name' => 'Search']);
            LayoutPage::create(['name' => 'Cart']);
            LayoutPage::create(['name' => 'Checkout']);
            LayoutPage::create(['name' => 'Finalization']);
            LayoutPage::create(['name' => 'Payment']);
            LayoutPage::create(['name' => 'ClientWishList']);
            LayoutPage::create(['name' => 'ClientOrder']);
            LayoutPage::create(['name' => 'ClientAddress']);
            LayoutPage::create(['name' => 'ClientSettings']);
            LayoutPage::create(['name' => 'Login']);
            LayoutPage::create(['name' => 'Registration']);
            LayoutPage::create(['name' => 'ForgotPassword']);
            LayoutPage::create(['name' => 'Page']);
            LayoutPage::create(['name' => 'Sitemap']);
            LayoutPage::create(['name' => 'Blog']);
            LayoutPage::create(['name' => 'Newsletter']);
        }

        if (!$this->getDb()->schema()->hasTable('layout_page_column')) {
            $this->getDb()->schema()->create('layout_page_column', function ($table) {
                $table->increments('id');
                $table->integer('layout_theme_id')->unsigned();
                $table->integer('layout_page_id')->unsigned();
                $table->integer('hierarchy')->unsigned()->default(0);
                $table->integer('width')->unsigned()->default(0);
                $table->timestamps();
                $table->foreign('layout_theme_id')->references('id')->on('layout_theme')->onDelete('CASCADE')->onUpdate('NO ACTION');
                $table->foreign('layout_page_id')->references('id')->on('layout_page')->onDelete('CASCADE')->onUpdate('NO ACTION');
                $table->unique(Array('layout_theme_id', 'layout_page_id'));
            });
        }

        if (!$this->getDb()->schema()->hasTable('layout_page_column_box')) {
            $this->getDb()->schema()->create('layout_page_column_box', function ($table) {
                $table->increments('id');
                $table->integer('layout_page_column_id')->unsigned();
                $table->integer('layout_box_id')->unsigned();
                $table->integer('hierarchy')->unsigned()->default(0);
                $table->integer('span')->unsigned()->default(1);
                $table->timestamps();
                $table->foreign('layout_page_column_id')->references('id')->on('layout_page_column')->onDelete('CASCADE')->onUpdate('NO ACTION');
                $table->foreign('layout_box_id')->references('id')->on('layout_box')->onDelete('CASCADE')->onUpdate('NO ACTION');
            });
        }
    }

    public function down()
    {

    }
}