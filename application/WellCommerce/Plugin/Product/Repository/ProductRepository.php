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
namespace WellCommerce\Plugin\Product\Repository;

use WellCommerce\Core\Component\Repository\AbstractRepository;
use WellCommerce\Core\Component\Repository\RepositoryInterface;
use WellCommerce\Plugin\Product\Model\Product;
use WellCommerce\Plugin\Product\Model\ProductTranslation;

/**
 * Class ProductAbstractRepository
 *
 * @package WellCommerce\Plugin\Product\AbstractRepository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductRepository extends AbstractRepository implements RepositoryInterface
{
    /**
     * Returns product collection
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Product::with('translation', 'shop', 'deliverer', 'photos')->get();
    }

    /**
     * Returns single product model with all shop and deliverer data
     *
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function find($id)
    {
        return Product::with('translation', 'shop', 'deliverer', 'photos')->findOrFail($id);
    }

    /**
     * Deletes product by key or multiple products if array of ids is passed
     *
     * @param array|int $id
     */
    public function delete($id)
    {
        $this->transaction(function () use ($id) {
            return Product::destroy($id);
        });
    }

    /**
     * Saves product model
     *
     * @param array    $Data Submitted form data
     * @param int|null $id   Product ID or null if new product
     */
    public function save(array $Data, $id = null)
    {
        $this->transaction(function () use ($Data, $id) {
            $product = Product::firstOrNew([
                'id' => $id
            ]);

            $product->enabled          = $Data['enabled'];
            $product->ean              = $Data['ean'];
            $product->sku              = $Data['sku'];
            $product->producer_id      = $Data['producer_id'];
            $product->stock            = $Data['stock'];
            $product->track_stock      = $Data['track_stock'];
            $product->tax_id           = $Data['tax_id'];
            $product->sell_currency_id = $Data['sell_currency_id'];
            $product->buy_currency_id  = $Data['buy_currency_id'];
            $product->buy_price        = $Data['buy_price'];
            $product->sell_price       = $Data['sell_price'];
            $product->weight           = $Data['weight'];
            $product->width            = $Data['width'];
            $product->height           = $Data['height'];
            $product->depth            = $Data['depth'];
            $product->package_size     = $Data['package_size'];
            if (0 == $Data['photo']['unmodified']) {
                if (isset($Data['photo']['main'])) {
                    $product->photo_id = $Data['photo']['main'];
                } else {
                    $product->photo_id = null;
                }

            }
            $product->save();

            foreach ($this->getLanguageIds() as $language) {

                $translation = ProductTranslation::firstOrNew([
                    'product_id'  => $product->id,
                    'language_id' => $language
                ]);

                $translation->setTranslationData($Data, $language);
                $translation->save();
            }

            $product->sync($product->deliverer(), $Data['deliverers']);
            $product->sync($product->category(), $Data['category']);
            $product->sync($product->shop(), $Data['shops']);
            if (0 == $Data['photo']['unmodified']) {
                $photos = $this->preparePhotos($Data['photo']);
                $product->sync($product->photos(), $photos);
            }
        });
    }

    /**
     * Prepares photos data stripping all non-id values from data
     *
     * @param $Data
     *
     * @return array
     */
    private function preparePhotos($Data)
    {
        $photos = [];
        foreach ($Data as $key => $value) {
            if (!is_array($value) && is_int($key) && ($value > 0)) {
                $photos[] = $value;
            }
        }

        return $photos;
    }

    /**
     * Saves basic product values directly from DataGrid
     *
     * @param array $request
     *
     * @return array
     */
    public function updateDataGridRow($request)
    {
        $id   = $request['id'];
        $data = $request['data'];

        $this->transaction(function () use ($id, $data) {
            $product             = $this->find($id);
            $product->ean        = $data['ean'];
            $product->stock      = $data['stock'];
            $product->sell_price = $data['sell_price'];
            $product->hierarchy  = $data['hierarchy'];
            $product->weight     = $data['weight'];
            $product->save();
        });

        return [
            'updated' => true
        ];
    }

    /**
     * Returns array containing values needed to populate the form
     *
     * @param int $id Product ID
     *
     * @return array Populate data
     */
    public function getPopulateData($id)
    {
        $productData  = $this->find($id);
        $populateData = [];
        $accessor     = $this->getPropertyAccessor();
        $languageData = $productData->getTranslationData();

        $accessor->setValue($populateData, '[basic_pane]', [
            'language_data' => $languageData,
            'enabled'       => $productData->enabled,
            'ean'           => $productData->ean,
            'sku'           => $productData->sku,
            'producer_id'   => $productData->producer_id,
            'deliverers'    => $productData->getDeliverers(),
        ]);

        $accessor->setValue($populateData, '[stock_pane]', [
            'stock'       => $productData->stock,
            'track_stock' => $productData->track_stock,
        ]);

        $accessor->setValue($populateData, '[category_pane]', [
            'category' => $productData->getCategories()
        ]);

        $accessor->setValue($populateData, '[description_data]', [
            'language_data' => $languageData
        ]);

        $accessor->setValue($populateData, '[meta_data]', [
            'language_data' => $languageData
        ]);

        $accessor->setValue($populateData, '[price_pane]', [
            'tax_id'           => $productData->tax_id,
            'sell_currency_id' => $productData->sell_currency_id,
            'buy_currency_id'  => $productData->buy_currency_id,
            'buy_price'        => $productData->buy_price,
            'standard_price'   => [
                'sell_price' => $productData->sell_price,
            ]
        ]);

        $accessor->setValue($populateData, '[measurements_pane]', [
            'weight'       => $productData->weight,
            'width'        => $productData->width,
            'height'       => $productData->height,
            'depth'        => $productData->depth,
            'package_size' => $productData->package_size,

        ]);

        $accessor->setValue($populateData, '[photos_pane]', [
            'photo' => $productData->getPhotos(),
            'main'  => $productData->photo_id
        ]);

        $accessor->setValue($populateData, '[shop_data]', [
            'shops' => $productData->getShops()
        ]);

        return $populateData;
    }
}