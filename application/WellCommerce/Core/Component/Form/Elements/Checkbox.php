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

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class Checkbox
 *
 * @package WellCommerce\Core\Component\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Checkbox extends Field implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureAttributes(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'name',
            'label'
        ]);

        $resolver->setOptional([
            'class',
            'error',
            'comment',
            'default',
        ]);

        $resolver->setAllowedTypes([
            'name'    => 'string',
            'label'   => 'string',
            'class'   => 'string',
            'error'   => 'string',
            'comment' => 'string',
            'default' => 'integer'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesJs()
    {
        $attributes = [
            $this->formatAttributeJs('name', 'sName'),
            $this->formatAttributeJs('label', 'sLabel'),
            $this->formatAttributeJs('comment', 'sComment'),
            $this->formatAttributeJs('error', 'sError'),
            $this->formatRulesJs(),
            $this->formatDependencyJs(),
            $this->formatDefaultsJs()
        ];

        return $attributes;
    }
}
