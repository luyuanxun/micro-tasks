<?php

namespace App\Tasks\Services;

use Phalcon\Db\Column;
use Phalcon\Di;

/**
 * Class ModelService
 * @package App\Tasks\Services
 */
class ModelService extends BaseService
{
    /**
     * 生成模型
     */
    public function create()
    {
        $modelsDir = Di::getDefault()->get('config')->application->modelsDir;
        $modelName = $modelsDir . $this->className . '.php';
        if (file_exists($modelName) && !$this->force) {
            echo '提示：生成失败，model已存在：' . $modelName . PHP_EOL;
            return;
        }

        $template = file_get_contents($this->templatesDir . 'model.php');
        $template = str_replace(':table:', $this->table, $template);
        $template = str_replace(':className:', $this->className, $template);
        $template = str_replace(':lowerClassName:', $this->lowerClassName, $template);

        $attributes = '';
        $saveColumn = '';
        $columnMap = '';
        foreach ($this->columns as $column) {
            /**
             * 处理模型属性
             */
            $type = 'string';
            if (in_array($column['type'], [Column::TYPE_INTEGER, Column::TYPE_FLOAT, Column::TYPE_DOUBLE, Column::TYPE_BIGINTEGER])) {
                $type = 'integer';
            }

            $attributes .= str_repeat(' ', 4) . '/**' . PHP_EOL . str_repeat(' ', 4) . ' * @var ' . $type . PHP_EOL . str_repeat(' ', 4) . ' */' . PHP_EOL;
            $attributes .= str_repeat(' ', 4) . 'public $' . $column['name'] . ';' . PHP_EOL . PHP_EOL;

            /**
             * 处理允许创建|修改字段
             */
            if ($column['name'] !== $this->primaryKey) {
                $saveColumn .= "'" . $column['name'] . "', ";
            }

            /**
             * 处理columnMap
             */
            $columnMap .= str_repeat(' ', 12) . "'" . $column['fieldName'] . "' => '" . $column['name'] . "'," . PHP_EOL;
        }

        $saveColumn = rtrim($saveColumn, ', ');
        $getColumn = "'" . $this->primaryKey . "', " . $saveColumn;
        $template = str_replace(':attributes:', rtrim($attributes, PHP_EOL), $template);
        $template = str_replace(':saveColumn:', $saveColumn, $template);
        $template = str_replace(':getColumn:', $getColumn, $template);
        $template = str_replace(':columnMap:', rtrim($columnMap, PHP_EOL), $template);
        file_put_contents($modelName, $template);
        echo 'model生成成功：' . $modelName . PHP_EOL;
    }
}