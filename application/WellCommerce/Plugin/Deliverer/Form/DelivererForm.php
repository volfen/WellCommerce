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
namespace WellCommerce\Plugin\Deliverer\Form;

use WellCommerce\Core\Component\Form\AbstractFormBuilder;
use WellCommerce\Core\Component\Form\FormInterface;
use WellCommerce\Plugin\Deliverer\Event\DelivererFormEvent;

/**
 * Class DelivererForm
 *
 * @package WellCommerce\Plugin\Deliverer\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DelivererForm extends AbstractFormBuilder implements FormInterface
{

    public function init($delivererData = [])
    {
        $form = $this->addForm([
            'name' => 'deliverer'
        ]);

        $requiredData = $form->addChild($this->addFieldset([
            'name'  => 'required_data',
            'label' => $this->trans('Basic settings')
        ]));

        $languageData = $requiredData->addChild($this->addFieldsetLanguage([
            'name'      => 'language_data',
            'label'     => $this->trans('Language settings'),
            'languages' => $this->getLanguages()
        ]));

        $languageData->addChild($this->addTextField([
            'name'  => 'name',
            'label' => $this->trans('Name'),
            'rules' => [
                $this->addRuleRequired($this->trans('Name is required')),
                $this->addRuleUnique($this->trans('Deliverer already exists'),
                    [
                        'table'   => 'deliverer_translation',
                        'column'  => 'name',
                        'exclude' => [
                            'column' => 'deliverer_id',
                            'values' => $this->getParam('id')
                        ]
                    ]
                )
            ]
        ]));

        $form->addFilter($this->addFilterNoCode());
        $form->addFilter($this->addFilterTrim());
        $form->addFilter($this->addFilterSecure());

        $event = new DelivererFormEvent($form, $delivererData);

        $this->getDispatcher()->dispatch(DelivererFormEvent::FORM_INIT_EVENT, $event);

        $form->populate($event->getPopulateData());

        return $form;
    }
}
