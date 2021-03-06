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
namespace WellCommerce\Plugin\File\Controller\Admin;

use WellCommerce\Core\Controller\AbstractAdminController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class FileController
 *
 * @package WellCommerce\Plugin\File\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FileController extends AbstractAdminController
{
    public function addAction()
    {
        $request  = $this->getRequest();
        $uploader = $this->getUploader();
        $files    = $uploader->getFiles($request->files);

        foreach ($files as $file) {
            $data = $this->getRepository()->save($file);
            $name = sprintf('%s.%s', $data->id, $data->extension);
            $uploader->upload($file, $name);
        }

        // delete file cache
        $this->getCache()->delete('files');

        $response = [
            'sId'        => $data->id,
            'sThumb'     => $this->getImageGallery()->getImageUrl($data->id, 100, 100),
            'sFilename'  => $data->name,
            'sExtension' => $data->extension,
            'sFileType'  => $data->type
        ];

        return new JsonResponse($response);
    }

    /**
     * {@inheritdoc}
     */
    protected function getDataGrid()
    {
        return $this->get('product.datagrid');
    }

    /**
     * {@inheritdoc}
     */
    protected function getRepository()
    {
        return $this->get('file.repository');
    }

    /**
     * {@inheritdoc}
     */
    protected function getForm()
    {
        return $this->get('file.form');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultRoute()
    {
        return 'admin.file.index';
    }
}
