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

namespace WellCommerce\Core\Component\Form\Elements;

/**
 * Class ProductSelect
 *
 * @package WellCommerce\Core\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductSelect extends Select implements ElementInterface
{

    public $datagrid;

    protected $_jsFunction;

    public function __construct($attributes)
    {
        parent::__construct($attributes);
        $this->_jsFunction               = 'LoadProducts_' . $this->_id;
        $this->attributes['jsfunction'] = 'xajax_' . $this->_jsFunction;
        App::getRegistry()->xajax->registerFunction(array(
            $this->_jsFunction,
            $this,
            'loadProducts_' . $this->_id
        ));
        $this->attributes['load_categorychildren'] = App::getRegistry()->xajaxInterface->registerFunction(array(
            'LoadCategoryChildren_' . $this->_id,
            $this,
            'loadCategoryChildren'
        ));
        if (isset($this->attributes['exclude_from'])) {
            $this->attributes['exclude_from_field'] = $this->attributes['exclude_from']->getName();
        }
        if (!isset($this->attributes['exclude'])) {
            $this->attributes['exclude'] = Array(0);
        }
        $this->attributes['datagrid_filter'] = $this->getDatagridfilterData();
    }

    public function __call($function, $arguments)
    {
        if ($function == 'loadProducts_' . $this->_id) {
            return call_user_func_array(Array(
                $this,
                'loadProducts'
            ), $arguments);
        }
    }

    protected function prepareAttributesJs()
    {
        $attributes = Array(
            $this->formatAttributeJs('name', 'sName'),
            $this->formatAttributeJs('label', 'sLabel'),
            $this->formatAttributeJs('comment', 'sComment'),
            $this->formatAttributeJs('error', 'sError'),
            $this->formatAttributeJs('exclude_from_field', 'sExcludeFrom'),
            $this->formatAttributeJs('jsfunction', 'fLoadProducts', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('advanced_editor', 'bAdvancedEditor', ElementInterface::TYPE_BOOLEAN),
            $this->formatAttributeJs('datagrid_filter', 'ofilterData', ElementInterface::TYPE_OBJECT),
            $this->formatAttributeJs('load_categorychildren', 'fLoadCategoryChildren', ElementInterface::TYPE_FUNCTION),
            $this->formatRepeatableJs(),
            $this->formatRulesJs(),
            $this->formatDependencyJs(),
            $this->formatDefaultsJs()
        );

        return $attributes;
    }

    public function loadCategoryChildren($request)
    {
        return Array(
            'aoItems' => $this->getCategories($request['parentId'])
        );
    }

    protected function getCategories($parent = 0)
    {
        $categories = App::getModel('category')->getChildCategories($parent);
        usort($categories, Array(
            $this,
            'sortCategories'
        ));

        return $categories;
    }

    protected function sortCategories($a, $b)
    {
        return $a['weight'] - $b['weight'];
    }

    public function loadProducts($request, $processFunction)
    {
        if (isset($request['dynamic_exclude']) && is_array($request['dynamic_exclude'])) {
            $this->attributes['exclude'] = array_merge($this->attributes['exclude'], $request['dynamic_exclude']);
        } else {
            $this->attributes['exclude'] = Array(
                0
            );
        }
        $this->getDatagrid()->setAdditionalWhere('
			P.idproduct NOT IN (' . implode(',', $this->attributes['exclude']) . ')
		');

        return $this->getDatagrid()->getData($request, $processFunction);
    }

    public function getDatagrid()
    {
        if (($this->datagrid == null)) {
            $this->datagrid = App::getModel('datagrid/datagrid');
            $this->initDatagrid($this->datagrid);
        }

        return $this->datagrid;
    }

    public function getDatagridfilterData()
    {
        return $this->getDatagrid()->getfilterData();
    }

    public function processVariants($productId)
    {
        $rawVariants = App::getModel('product/product')->getAttributeCombinationsForProduct($productId);
        $variants    = [];
        $variants[]  = Array(
            'id'      => '',
            'caption' => Translation::get('TXT_ANY_VARIANT')
        );
        foreach ($rawVariants as $variant) {
            $caption = [];
            foreach ($variant['attributes'] as $attribute) {
                $caption[] = $attribute['name'];
            }
            $variants[] = Array(
                'id'      => $variant['id'],
                'caption' => implode(', ', $caption)
            );
        }

        return json_encode($variants);
    }

    protected function initDatagrid($datagrid)
    {
        $datagrid->setTableData('product', Array(
            'idproduct'          => Array(
                'source' => 'P.idproduct'
            ),
            'name'               => Array(
                'source'                => 'PT.name',
                'prepareForAutosuggest' => true
            ),
            'categoryname'       => Array(
                'source' => 'CT.name'
            ),
            'categoryid'         => Array(
                'source'         => 'PC.categoryid',
                'prepareForTree' => true,
                'first_level'    => $this->getCategories()
            ),
            'ancestorcategoryid' => Array(
                'source' => 'CP.ancestorcategoryid'
            ),
            'categoriesname'     => Array(
                'source' => 'GROUP_CONCAT(DISTINCT SUBSTRING(CONCAT(\' \', CT.name), 1))',
                'filter' => 'having'
            ),
            'sellprice'          => Array(
                'source' => 'P.sellprice'
            ),
            'sellprice_gross'    => Array(
                'source' => 'ROUND(P.sellprice * (1 + V.value / 100), 2)'
            ),
            'barcode'            => Array(
                'source'                => 'P.barcode',
                'prepareForAutosuggest' => true
            ),
            'ean'                => Array(
                'source' => 'P.ean',
            ),
            'buyprice'           => Array(
                'source' => 'P.buyprice'
            ),
            'buyprice_gross'     => Array(
                'source' => 'ROUND(P.buyprice * (1 + V.value / 100), 2)'
            ),
            'producer'           => Array(
                'source'           => 'PRT.name',
                'prepareForSelect' => true
            ),
            'vat'                => Array(
                'source'           => 'CONCAT(V.value, \'%\')',
                'prepareForSelect' => true
            ),
            'stock'              => Array(
                'source' => 'stock'
            ),
            'variant__options'   => Array(
                'source'          => 'P.idproduct',
                'processFunction' => ((isset($this->attributes['advanced_editor']) && $this->attributes['advanced_editor']) ? Array(
                        $this,
                        'processVariants'
                    ) : false)
            ),
            'thumb'              => Array(
                'source'          => 'PP.photoid',
                'processFunction' => Array(
                    $this,
                    'getThumbPathForId'
                )
            )
        ));
        $datagrid->setFrom('
			product P
			LEFT JOIN producttranslation PT ON P.idproduct = PT.productid AND PT.languageid = :languageid
			LEFT JOIN productcategory PC ON PC.productid = P.idproduct
			LEFT JOIN productphoto PP ON PP.productid = P.idproduct AND PP.mainphoto = 1
			LEFT JOIN category C ON C.idcategory = PC.categoryid
			LEFT JOIN categorypath CP ON C.idcategory = CP.categoryid
			LEFT JOIN categorytranslation CT ON C.idcategory = CT.categoryid AND CT.languageid = :languageid
			LEFT JOIN producer R ON P.producerid = R.idproducer
			LEFT JOIN producertranslation PRT ON P.producerid = PRT.producerid AND PRT.languageid = :languageid
			LEFT JOIN `vat` V ON P.vatid = V.idvat
		');

        $datagrid->setGroupBy('
			P.idproduct
		');

        if (isset($this->attributes['additional_rows'])) {
            $datagrid->setAdditionalRows($this->attributes['additional_rows']);
        }

    }

    public function getThumbPathForId($id)
    {
        if ($id > 1) {
            try {
                $image = App::getModel('gallery')->getSmallImageById($id);
            } catch (Exception $e) {
                $image = Array(
                    'path' => ''
                );
            }

            return $image['path'];
        } else {
            return '';
        }
    }

}