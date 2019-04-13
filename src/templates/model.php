<?php

namespace App\Models;

use App\Common\Code;
use Lyx\Micro\Tools\CustomException;
use Phalcon\Mvc\Model;

class :className: extends Base
{
:attributes:

    /**
     * 允许显示的字段
     * @var array
     */
    public $getColumn = [:getColumn:];

    /**
     * 允许创建|修改字段
     * @var array
     */
    public $saveColumn = [:saveColumn:];

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        parent::initialize();
        $this->setSchema("phalcon");
        $this->setSource(":table:");
    }

    /**
     * Returns table name mapped in the model.
     * @return string
     */
    public function getSource()
    {
        return ':table:';
    }

    /**
     * 处理更新时间
     */
    public function beforeSave()
    {

    }

    /**
     * 字段转驼峰
     * @return array
     */
    public function columnMap()
    {
        return [
:columnMap:
        ];
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getCount($params)
    {
        return :className:::count($params);
    }

    /**
     * @param $params
     * @return array
     */
    public function getAll($params)
    {
        if (empty($params['columns'])) {
            $params['columns'] = $this->getColumn;
        }

        return :className:::find($params)->toArray();
    }

    /**
     * @param $params
     * @return array
     * @throws CustomException
     */
    public function getOne($params)
    {
        if (empty($params['columns'])) {
            $params['columns'] = $this->getColumn;
        }

        $:lowerClassName: = :className:::findFirst($params);
        if (!$:lowerClassName:) {
            error_exit(Code::GET_DATA_FAILED, ['field' => ':className:']);
        }

        return $:lowerClassName:->toArray();
    }

    /**
     * @param $id
     * @return Model
     * @throws CustomException
     */
    public function model($id){
        $:lowerClassName: = :className:::findFirst($id);
        if (!$:lowerClassName:) {
            error_exit(Code::GET_DATA_FAILED, ['field' => ':className:']);
        }

        return $:lowerClassName:;
    }
}
