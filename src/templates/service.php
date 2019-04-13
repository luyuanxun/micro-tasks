<?php

namespace App\Services;

use App\Common\Code;
use App\Common\Constant;
use Lyx\Micro\Tools\CustomException;
use App\Models\:className:;

/**
 * Class :className:Service
 * @package App\Services
 */
class :className:Service
{
    /**
     * @var :className:
     */
    public $:lowerClassName:;

    /**
     * 初始化
     */
    public function __construct()
    {
        $this->:lowerClassName: = new :className:();
    }

    /**
     * 获取列表
     * @param $params
     * @return array
     */
    public function getList($params)
    {
        $page = $params['page'] ?? 1;
        $pageSize = $params['pageSize'] ?? Constant::PAGE_SIZE;
        return $this->:lowerClassName:->getList($page, $pageSize);
    }

    /**
     * 获取详情
     * @param $params
     * @return array
     * @throws CustomException
     */
    public function getInfo($params)
    {
        $data = [
            'columns' => [],
            'conditions' => ':primaryKey: = ::primaryKey::',
            'bind' => [
                ':primaryKey:' => $params[':primaryKey:']
            ]
        ];

        return $this->:lowerClassName:->getOne($data);
    }

    /**
     * 创建
     * @param $params
     * @throws CustomException
     */
    public function create($params)
    {
        $ret = $this->:lowerClassName:->create($params, $this->:lowerClassName:->saveColumn);
        if (!$ret) {
            error_exit(Code::CREATE_FAILED);
        }
    }

    /**
     * 修改
     * @param $params
     * @throws CustomException
     */
    public function update($params)
    {
        $ret = $this->:lowerClassName:->model($params[':primaryKey:'])->update($params, $this->:lowerClassName:->saveColumn);
        if (!$ret) {
            error_exit(Code::UPDATE_FAILED);
        }
    }

    /**
     * 删除
     * @param $params
     * @throws CustomException
     */
    public function delete($params)
    {
        $ret = $this->:lowerClassName:->model($params[':primaryKey:'])->delete();
        if (!$ret) {
            error_exit(Code::DELETE_FAILED);
        }
    }
}