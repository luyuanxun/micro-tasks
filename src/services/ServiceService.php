<?php

namespace App\Tasks\Services;

use Phalcon\Db\Column;
use Phalcon\Di;

/**
 * Class ModelService
 * @package App\Tasks\Services
 */
class ServiceService extends BaseService
{
    /**
     * 生成模型
     */
    public function create()
    {
        $servicesDir = Di::getDefault()->get('config')->application->servicesDir;
        $serviceName = $servicesDir . $this->className . 'Service.php';
        if (file_exists($serviceName) && !$this->force) {
            echo '提示：生成失败，service已存在：' . $serviceName . PHP_EOL;
            return;
        }

        $template = file_get_contents($this->templatesDir . 'service.php');
        $template = str_replace(':className:', $this->className, $template);
        $template = str_replace(':lowerClassName:', $this->lowerClassName, $template);
        $template = str_replace(':primaryKey:', $this->primaryKey, $template);

        file_put_contents($serviceName, $template);
        echo 'service生成成功：' . $serviceName . PHP_EOL;
    }

    /**
     * 生成路由
     */
    public function createRoute()
    {
        $route = PHP_EOL . PHP_EOL . '/**' . PHP_EOL . ' * ' . $this->className . 'Controller' . PHP_EOL . ' */' . PHP_EOL;
        $route .= '$' . $this->lowerClassName . ' = new MicroCollection();' . PHP_EOL;
        $route .= '$' . $this->lowerClassName . '->setHandler(new App\Controllers\\' . $this->className . 'Controller());' . PHP_EOL;
        $route .= '$' . $this->lowerClassName . '->setPrefix("/' . $this->lowerClassName . '");' . PHP_EOL;
        $route .= '$' . $this->lowerClassName . '->post("/", "create");' . PHP_EOL;
        $route .= '$' . $this->lowerClassName . '->delete("/", "delete");' . PHP_EOL;
        $route .= '$' . $this->lowerClassName . '->put("/", "update");' . PHP_EOL;
        $route .= '$' . $this->lowerClassName . '->get("/", "getInfo");' . PHP_EOL;
        $route .= '$' . $this->lowerClassName . '->get("/list", "getList");' . PHP_EOL;
        $route .= '$app->mount($' . $this->lowerClassName . ');' . PHP_EOL;

        //检查路由是否已存在
        $appFile = file_get_contents(APP_PATH . '/app.php');
        if (!(strpos($appFile, 'App\Controllers\\' . $this->className . 'Controller') !== false)) {
            file_put_contents(APP_PATH . '/app.php', rtrim($route, PHP_EOL), FILE_APPEND);
            echo '路由添加成功' . PHP_EOL;
        }
    }
}