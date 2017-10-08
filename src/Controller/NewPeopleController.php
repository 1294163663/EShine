<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/7
 * Time: 12:53
 */

namespace EShine\Controller;

use EShine\Model\NewPeopleModel;
use Slim\Http\Request;
use Slim\Http\Response;

require __DIR__ . '/../../vendor/autoload.php';

class NewPeopleController extends BaseController
{

    /**
     * @param Request $request
     * @param Response $response
     * @param $args array
     * @return mixed
     */
    public function __invoke(Request $request, Response $response, array $args)
    {
        // TODO: Implement __invoke() method.
    }

    public function getApplyStatus(Request $request, Response $response, array $args)
    {
        $params = $request->getParams();
        if (empty($params['name']) || empty($params['phone'])) {
            throw new \Exception("查询所需信息不足");
        }
        $people = new NewPeopleModel(['name'=>$params['name'], 'phone'=>$params['phone']]);
        $result = $people->find();
        $args['result'] = $result;
        return $this->renderer->render($response, 'query_result.phtml', $args);
    }

    public function newApply(Request $request, Response $response, array $args)
    {
        $params = $request->getParams();

        if (empty($params['name']) || empty($params['phone'])) {
            throw new \Exception("信息不足");
        }

        $image = $_FILES['image'];
        if (!empty($image['name'])) {

            if ((($image['type'] == "image/png")
                    || ($image['type'] == "image/jpeg")
                    || ($image['type'] == "image/jpg"))
               )
            {
                if ($image["error"] > 0) {
                    throw new \Exception($image["error"]);
                } else {
                    $fileName = __DIR__ . "/../../people_image/" . base64_encode($params['name'].$params['phone']) . '.jpg';
                    move_uploaded_file($image["tmp_name"], $fileName);
                    $fileUrl = $_SERVER['HTTP_HOST']  . "/EShine/people_image/" . base64_encode($params['name'].$params['phone']) . '.jpg';
                    $params['image'] = $fileUrl;
                }
            } else {
                throw new \Exception("文件格式不对");
            }
        }

        $people = new NewPeopleModel($params);
        $people->save();

        return $response->withRedirect($this->router->pathFor('queryResult', [], ['name'=>$params['name'], 'phone'=>$params['phone']]));
    }

    public function getNewPeopleExcel(Request $request, Response $response, array $args)
    {
        $people = new NewPeopleModel();
        $people->excelOut();
    }
}