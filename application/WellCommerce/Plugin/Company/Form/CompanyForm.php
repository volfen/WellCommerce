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
namespace WellCommerce\Plugin\Company\Form;

use WellCommerce\Core\Component\Form\AbstractForm;
use WellCommerce\Core\Component\Form\FormBuilder;
use WellCommerce\Core\Component\Form\FormInterface;
use WellCommerce\Core\Component\Model\ModelInterface;

/**
 * Class CompanyForm
 *
 * @package WellCommerce\Plugin\Company\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanyForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $form = $builder->addForm($options);

        $requiredData = $form->addChild($builder->addFieldset([
            'name'  => 'required_data',
            'label' => $this->trans('Required data')
        ]));

        $requiredData->addChild($builder->addTextField([
            'name'  => 'name',
            'label' => $this->trans('Name'),
            'rules' => [
                $builder->addRuleRequired($this->trans('Name is required')),
            ]
        ]));

        $requiredData->addChild($builder->addTextField([
            'name'  => 'short_name',
            'label' => $this->trans('Short name'),
            'rules' => [
                $builder->addRuleRequired($this->trans('Short name is required')),
            ]
        ]));

        $addressData = $form->addChild($builder->addFieldset([
            'name'  => 'address_data',
            'label' => $this->trans('Address data')
        ]));

        $addressData->addChild($builder->addTextField([
            'name'  => 'street',
            'label' => $this->trans('Street'),
        ]));

        $addressData->addChild($builder->addTextField([
            'name'  => 'streetno',
            'label' => $this->trans('Street number'),
        ]));

        $addressData->addChild($builder->addTextField([
            'name'  => 'flatno',
            'label' => $this->trans('Flat number'),
        ]));

        $addressData->addChild($builder->addTextField([
            'name'  => 'province',
            'label' => $this->trans('Province'),
        ]));

        $addressData->addChild($builder->addTextField([
            'name'  => 'postcode',
            'label' => $this->trans('Post code'),
        ]));

        $addressData->addChild($builder->addTextField([
            'name'  => 'city',
            'label' => $this->trans('City'),
        ]));

        $addressData->addChild($builder->addSelect([
            'name'    => 'country',
            'label'   => $this->trans('Country'),
            'options' => $builder->makeOptions($this->get('country.repository')->all())
        ]));

        $form->addFilters([
            $builder->addFilterNoCode(),
            $builder->addFilterTrim(),
            $builder->addFilterSecure()
        ]);

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function prepareData(ModelInterface $model)
    {
        $formData = [];
        $accessor = $this->getPropertyAccessor();

        $accessor->setValue($formData, '[required_data]', [
            'name'       => $model->name,
            'short_name' => $model->short_name
        ]);

        $accessor->setValue($formData, '[address_data]', [
            'street'   => $model->street,
            'streetno' => $model->streetno,
            'flatno'   => $model->flatno,
            'province' => $model->province,
            'postcode' => $model->postcode,
            'city'     => $model->city,
            'country'  => $model->country
        ]);

        return $formData;
    }
}
