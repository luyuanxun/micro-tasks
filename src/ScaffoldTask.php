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
     * @param array $params
     */
    public function restAction(array $params)
    {
        if (empty($params['table'])) {
            die('提示：没有设置数据表' . PHP_EOL);
        }

        $type = $params['type'] ?? 'crud';
        if (!in_array($type, ['crud', 'controller', 'model'])) {
            die('提示：命令 run scaffold ' . $type . ' 错误' . PHP_EOL);
        }

        $this->$type([
            'conn' => $this->di->getShared('dbSlave'),
            'table' => $params['table'],
            'force' => $params['f'] ?? false,
        ]);
    }

    /**
     * 根据模版生成控制器
     * @param array $params
     */
    private function controller(array $params)
    {
        $controllerService = new ControllerService();
        $controllerService->init($params)->create();
    }

    /**
     * 根据模版生成模型
     * @param array $params
     */
    private function model(array $params)
    {
        $modelService = new ModelService();
        $modelService->init($params)->create();
    }

    /**
     * 生成crud
     * @param array $params
     */
    public function crud(array $params)
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
        echo '恭喜恭喜，请根据' . APP_PATH . '/app.php的路由规则测试一波' . PHP_EOL;
    }
}
