<?php
namespace  backend\controllers;


use backend\models\Article;
use backend\models\Article_detail;
use backend\models\Category;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;

class ArticleController extends Controller{

    Public function actionAdd(){
        $article = new Article();
        $article_detail = new Article_detail();
        $request= new Request();
        //取出分类信息
        $categorys= Category::find()->where(["status"=>["1","0"]])->all();
        //拼装id
        $ids=[];
        foreach($categorys as $id=>$v){
            $ids[$v["id"]]=$v["name"];
        }

        if($request->isPost){
            //接收数据分模型修改
            $article->load($request->post());
            $article_detail->load($request->post());
            if($article->validate() && $article_detail->validate()) {

                $article->create_time = time();
//            var_dump($article);die;
                $article->save();
                //获取上次操作id
                $id = $article->getPrimaryKey();
                $article_detail->article_id = $id;
                $article_detail->save();
                //回到显示页面
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['list']);
            }
        }


        //发送数据
        $article->status=1;
        return $this->render("add",["article"=>$article,"ids"=>$ids,"article_detail"=>$article_detail]);
    }
    public function actionEdit($id){
        $article = Article::findOne(["id" => $id]);

        $article_detail = Article_detail::findOne(["article_id" => $id]);
        $request= new Request();
        //取出分类信息
        $categorys= Category::find()->where(["status"=>["1","0"]])->all();
        //拼装id
        $ids=[];
        foreach($categorys as $id=>$v){
            $ids[$v["id"]]=$v["name"];
        }

        if($request->isPost){
            //接收数据分模型修改
            $article->load($request->post());
            $article_detail->load($request->post());
            if($article->validate() && $article_detail->validate()) {

                $article->create_time = time();
//            var_dump($article);die;
                $article->save();
                //获取上次操作id
                $id = $article->getPrimaryKey();
                $article_detail->article_id = $id;
                $article_detail->save();
                //回到显示页面
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['list']);
            }
        }


        //发送数据
        $article->status=1;
        return $this->render("add",["article"=>$article,"ids"=>$ids,"article_detail"=>$article_detail]);

    }
    public function actionList(){
        //显示分页  实例化分页工具类
        $pager = new Pagination();
        $pager->totalCount = Article::find()->count();
        //        var_dump($pager->totalCount);die;
        $pager->pagesize = 2;//设置默认最大显示条数
        /*var_dump(Brand::find()->all());*/

        $models = Article::find()->limit($pager->limit)->offset($pager->offset)->where(["status"=>["1","0"]])->all();
        //显示数据

        return $this->render("list", ["models" => $models, "pager" => $pager]);
    }
    public function actionDel($id){
        //接收ajax数据   逻辑删除数据  即将状态改为-1[
        $model= Article::findOne(["id"=>$id]);
        $model->status= -1;
        $model->save(false);
        echo "1";
    }

}
