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
namespace WellCommerce\Core\Event;

use Symfony\Component\EventDispatcher\Event;
use WellCommerce\Core\Component\Form\Elements\Form;
use WellCommerce\Core\Component\Model\ModelInterface;

/**
 * Class FormEvent
 *
 * @package WellCommerce\Core\Event
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FormEvent extends Event
{

    protected $form;
    protected $data;

    /**
     * Constructor
     *
     * @param Form $form
     */
    public function __construct(Form $form, $data)
    {
        $this->form = $form;
        $this->data = $data;
    }

    /**
     * Returns form instance
     *
     * @return FormInterface|Form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Returns data
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Sets new data to populate the form
     *
     * @param $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}