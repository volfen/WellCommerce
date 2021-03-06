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

namespace WellCommerce\Core\Component\Form;

use WellCommerce\Core\Component\Model\ModelInterface;

/**
 * Interface FormInterface
 *
 * @package WellCommerce\Core\Component\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface FormInterface
{
    /**
     * Builds the form
     *
     * @param FormBuilder $builder FormBuilder instance
     * @param array       $options Form options
     *
     * @return mixed
     */
    public function buildForm(FormBuilder $builder, array $options);

    /**
     * Prepares form default values using retrieved model data
     *
     * @param ModelInterface $model
     *
     * @return array
     */
    public function prepareData(ModelInterface $model);
}