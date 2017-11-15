<?php

namespace backend\controllers;


use backend\models\Brand;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;

class BrandController extends Controller
{

    public function actionAdd()
    {
        $model = new Brand();
        $request = new Request();

        if ($request->isPost) {
            $model->load($request->post());
            var_dump(   $model);die;
            if ($model->validate()) {
                //验证通过后保存
                /*var_dump($model);die;*/
                $model->save(false);
                \Yii::$app->session->setFlash('success', '添加成功');
                return $this->redirect('list');
            }
        }
        $model->status = 1;  //默认正常状态
        return $this->render("add", ["model" => $model]);
    }

    Public function actionList()
    {
        //显示分页  实例化分页工具类
        $pager = new Pagination();
        $pager->totalCount = Brand::find()->where(["status"=>1])->count();
        //        var_dump($pager->totalCount);die;
        $pager->pagesize = 2;//设置默认最大显示条数
        /*var_dump(Brand::find()->all());*/

        $models = Brand::find()->limit($pager->limit)->offset($pager->offset)->where(["status"=>["1","0"]])->all();
        //显示数据
        /*var_dump($models);die;*/
        return $this->render("list", ["models" => $models, "pager" => $pager]);
    }

    public function actionEdit($id)
    {
        $model = Brand::findOne(["id" => $id]);
        $request = new Request();
        if ($request->isPost) {
            //接收数据 做修改
            $model->load($request->post());
            if ($model->validate()) {
                //保存数据
                $model->save();
                //保存后跳转到list
                \Yii::$app->session->setFlash('success', '修改成功');
                return $this->redirect('list');
            }
        }
        //发送数据做回显
        return $this->render("add", ["model" => $model]);
    }
    Public function actionDel($id){
        //接收ajax数据   逻辑删除数据  即将状态改为-1[
        $model= Brand::findOne(["id"=>$id]);
        $model->status= -1;
        $model->save(false);
        echo "1";
    }
    //ak  faOGFfcRLxWBKwwJOU0wE5S54M5pN9FRB3hgM7kY

    // sk   HqCLWrPu_QGKVPstLLmKc3Mp67Y1gVzfFmtTAOUJ

    public function actionTest(){


        // 需要填写你的 Access Key 和 Secret Key
        $accessKey ="faOGFfcRLxWBKwwJOU0wE5S54M5pN9FRB3hgM7kY";
        $secretKey = "HqCLWrPu_QGKVPstLLmKc3Mp67Y1gVzfFmtTAOUJ";
        //对象存储 空间名称
        $bucket = "php0711";

        // 构建鉴权对象
        $auth = new Auth($accessKey, $secretKey);

        // 生成上传 Token
        $token = $auth->uploadToken($bucket);

        // 要上传文件的本地路径
        $filePath = \Yii::getAlias('@webroot').'/upload/59fe779423988.jpg';

        // 上传到七牛后保存的文件名
        $key = '/upload/59fe779423988.jpg';

        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();

        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        echo "\n====> putFile result: \n";
        if ($err !== null) {
            //上传失败 打印错误
            var_dump($err);
        } else {
            //没有出错  打印上传结果
            var_dump($ret);

        }

    }
    Public function actionUpload()
    {
        $imgFile = UploadedFile::getInstanceByName('file');//file相当于输入框名字
        //如果有文件上传
        if ($imgFile) {
            //上传文件的保存地址
            $fileName = '/uploads/' . uniqid() . '.' . $imgFile->extension;
            $imgFile->saveAs(\Yii::getAlias('@webroot') . $fileName, false);
            //保存成功


            //返回路径
            return json_encode($fileName);
        }
    }

}
