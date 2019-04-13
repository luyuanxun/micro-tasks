<?php

namespace App\Controllers;

use Lyx\Micro\Tools\CustomValidation;
use Lyx\Micro\Tools\CustomException;
use App\Services\:className:Service;

/**
 * Class :className:Controller
 * @package App\Controllers
 */
class :className:Controller extends BaseController
{
    /**
     * @var :className:Service
     */
    public $:lowerClassName:Service;

    /**
     * 初始化
     */
    public function onConstruct()
    {
        $this->:lowerClassName:Service = new :className:Service();
    }

    /**
     * 获取列表
     * @return array
     * @throws CustomException
     */
    public function getList()
    {
        $rules = [
            'page' => 'required|digit|between:1',
            'pageSize' => 'required|digit|between:1',
        ];

        $params = CustomValidation::validate($this->getParams(), $rules);
        $this->di->getService('encryptFields')->setDefinition([':primaryKey:']);//若主键名为id，此行可删掉，默认加密id
        return $this->:lowerClassName:Service->getList($params);
    }

    /**
     * 根据ID获取详情
     * @return array
     * @throws CustomException
     */
    public function getInfo()
    {
        $rules = [
            ':primaryKey:' => 'required|strLen:24',
        ];

        $params = CustomValidation::validate($this->getParams(), $rules);
        $this->di->getService('encryptFields')->setDefinition([':primaryKey:']);//若主键名为id，此行可删掉，默认加密id
        return $this->:lowerClassName:Service->getInfo($params);
    }

    /**
     * 创建
     * @throws CustomException
     */
    public function create()
    {
        $rules = [
            :saveRules:
        ];

        $params = CustomValidation::validate($this->getParams(), $rules);
        $this->:lowerClassName:Service->create($params);
    }

    /**
     * 修改
     * @throws CustomException
     */
    public function update()
    {
        $rules = [
            ':primaryKey:' => 'required|strLen:24',
            :saveRules:
        ];

        $params = CustomValidation::validate($this->getParams(), $rules);
        $this->:lowerClassName:Service->update($params);
    }

    /**
     * 删除
     * @throws CustomException
     */
    public function delete()
    {
        $rules = [
            ':primaryKey:' => 'required|strLen:24',
        ];

        $params = CustomValidation::validate($this->getParams(), $rules);
        $this->:lowerClassName:Service->delete($params);
    }
}

