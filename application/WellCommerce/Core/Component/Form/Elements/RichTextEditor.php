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
 * Class RichTextEditor
 *
 * @package WellCommerce\Core\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RichTextEditor extends Textarea implements ElementInterface
{

    public function __construct($attributes)
    {
        parent::__construct($attributes);
        $this->attributes['advanced'] = true;
    }

    public function prepareAttributesJs()
    {
        $attributes = Array(
            $this->formatAttributeJs('name', 'sName'),
            $this->formatAttributeJs('label', 'sLabel'),
            $this->formatAttributeJs('rows', 'iRows', ElementInterface::TYPE_NUMBER),
            $this->formatAttributeJs('cols', 'iCols', ElementInterface::TYPE_NUMBER),
            $this->formatAttributeJs('comment', 'sComment'),
            $this->formatAttributeJs('error', 'sError'),
            $this->formatAttributeJs('advanced', 'bAdvanced'),
            $this->formatAttributeJs('language', 'sLanguage'),
            $this->formatRepeatableJs(),
            $this->formatRulesJs(),
            $this->formatDependencyJs(),
            $this->formatDefaultsJs()
        );

        return $attributes;
    }

}
