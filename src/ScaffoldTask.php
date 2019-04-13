<?php

namespace App\Tasks;

use App\Tasks\Services\ControllerService;
use App\Tasks\Services\ModelService;
use App\Tasks\Services\ServiceService;
use Phalcon\Cli\Task;

class ScaffoldTask extends Task
{
    /**
     * 生成restful脚手架
     * @param $params
     */
    public function restAction($params)
    {
        $data = [
            'conn' => $this->di->getShared('dbSlave'),
            'force' => false,
        ];

        $type = 'crud';
        foreach ($params as $param) {
            if (strpos($param, '--type=') !== false) {
                $type = substr($param, 7);
            }

            if (strpos($param, '--table=') !== false) {
                $data['table'] = substr($param, 8);
            }

            if ($param === '-f') {
                $data['force'] = true;
            }
        }

        if (!in_array($type, ['crud', 'controller', 'model'])) {
            die('提示：命令 run ' . $argv[1] . ' ' . $argv[2] . ' 错误' . PHP_EOL);
        }

        if (empty($data['table'])) {
            die('提示：没有设置数据表' . PHP_EOL);
        }

        $this->$type($data);
    }

    /**
     * 根据模版生成控制器
     * @param $params
     */
    private function controller($params)
    {
        $controllerService = new ControllerService();
        $controllerService->init($params)->create();
    }

    /**
     * 根据模版生成模型
     * @param $params
     */
    private function model($params)
    {
        $modelService = new ModelService();
        $modelService->init($params)->create();
    }

    /**
     * 生成crud
     * @param $params
     */
    public function crud($params)
    {
        //controller
        $controllerService = new ControllerService();
        $controllerService->init($params)->create();

        //model
        $modelService = new ModelService();
        $modelService->init($params)->create();

        //service
        $serviceService = new ServiceService();
        $serviceService->init($params)->create();
        $serviceService->createRoute();//生成路由
        echo 'CURD完成！！！' . PHP_EOL;
        echo '恭喜恭喜，请根据' . APP_PATH . '/app.php的路由规则测试一波'.PHP_EOL;
    }
}
