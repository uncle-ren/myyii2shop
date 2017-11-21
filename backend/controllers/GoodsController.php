<?php
namespace  backend\controllers;


use backend\models\Brand;
use backend\models\Goods;
use backend\models\Goods_category;
use backend\models\Goods_day_count;
use backend\models\Goods_gallery;
use backend\models\Goods_intro;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;

class GoodsController extends Controller{

    public function  actionAdd(){

        $model=new Goods();
        $good_intro= new Goods_intro();
        $request= new Request();
        if($request->isPost){
          /*var_dump(\Yii::$app->db->getLastInsertID());die;*/
            /*var_dump($model->);die;*/
            $model->imgfile=UploadedFile::getInstance($model,'imgfile');
            $ext= $model->imgfile->extension;//获取上传文件的扩展名
            $file = '/uploads/'.uniqid().'.'.$ext;
            $model->imgfile->saveAs(\Yii::getAlias('@webroot').$file,0);
            //验证数据

                //验证成功后
                $model->logo=$file;
            $a=Goods::find()->orderBy(["id"=>"asc"])->all();
            if($a){
                //能取出值,则sn在原来基础上+1
                foreach($a as $fg) {
                    $id=$fg->id;
                };
                $sn1=(Goods::findOne(["id"=>$id])->sn)+1;
                $a=substr($sn1,8) ;
                $sn=date("Ymd",time()).$a;

            }else{
                //第一次添加数据的话
                $sn=date("Ymd",time())."00001";
            }
               //$a= \Yii::$app->db->getLastInsertID();
            //  拼接上新的编号
//var_dump($sn);die;

                //设置添加时间和货号sn
                $model->create_time=time();
                $model->view_times=0;//默认浏览次数
                $model->sn=$sn;
                $model->load($request->post());
                //保存进数据库
            //var_dump($model);die;
                $model->save(0);
                //保存后 获取id  添加到数据库

                $good_intro->load($request->post());
                $good_intro->goods_id=$model->id;

                /*var_dump($good_intro);echo"<hr/>";
                var_dump($model);die;*/
                $good_intro->save(false);
                //判断 goods_day_count是否已存在今天的记录
            if(Goods_day_count::findOne(["day"=>date("Y-m-d",time())])){
                    //如果能找出来
                $result=Goods_day_count::findOne(["day"=>date("Y-m-d",time())]);
                $result->count=($result->count)+1;
                $result->save();
            }else{
                $result = new Goods_day_count();
                $result->day= date("Y-m-d",time());
                $result->count= 1;
                $result->save();
                //保存到 goods_day_count中
            }

                //将logo加到表中
            $result= new Goods_gallery();
            $result->goods_id=$model->id;
            $result->path=$file;
            $result->save(0);
            \Yii::$app->session->setFlash('success', '添加成功');
            return $this->redirect('list');
        }


        //获取品牌分类  商品分类使用个ztree插件
        $brand_old= Brand::find()->all();
        //循环组成 想要的数据
        $brand=[];

           foreach($brand_old  as $k=>$v){
               $brand[$k]= $v["name"];
           }
        $model->goods_category_id=0;
        return $this->render("add",["model"=>$model,"brand"=>$brand,"goods_intro"=>$good_intro]);
    }
    public function  actionEdit($id){
        $model= Goods::findOne(["id"=>$id]);
        $good_intro= Goods_intro::findOne(["goods_id"=>$id]);
        $request= new Request();
        if($request->isPost){
            $model->imgfile=UploadedFile::getInstance($model,'imgfile');
            $ext= $model->imgfile->extension;//获取上传文件的扩展名
            $file = '/uploads/'.uniqid().'.'.$ext;
            $model->imgfile->saveAs(\Yii::getAlias('@webroot').$file,0);

            $model->logo=$file;
            //设置添加时间和货号sn

            $model->view_times=($model->view_times)+1;//默认浏览次数

            $model->load($request->post());
            //保存进数据库

            $model->save(false);

            //保存后 获取id  添加到数据库
            $good_intro->load($request->post());
            $good_intro->goods_id=$id;

            $good_intro->save(false);
            //判断 goods_day_count是否已存在今天的记录


            //再生成sn保存到 goods_day_conut 中
            \Yii::$app->session->setFlash('success', '修改成功');
            return $this->redirect('list');
        }


        //获取品牌分类  商品分类使用个ztree插件
        $brand_old= Brand::find()->all();
        //循环组成 想要的数据
        $brand=[];

        foreach($brand_old  as $k=>$v){
            $brand[$k]= $v["name"];
        }

        return $this->render("add",["model"=>$model,"brand"=>$brand,"goods_intro"=>$good_intro]);



    }
    public function  actionDel($id){
        $model= Goods::findOne(["id"=>$id]);
        $model->status=0;
        $model->imgfile=$model->logo;

        $model->save();
        //为什么修改不了?????
        if($model->save(false)){
            echo "1";
        }else{

          var_dump($model->errors)  ;
        }

    }
    public function  actionList(){
        // var_dump($_SERVER["REMOTE_ADDR"]);die;
        $pager= new Pagination();
        $pager->totalCount= Goods::find()->where(["status"=>1])->count();
        $pager->pageSize=5;
        $data=$_GET;
        /*var_dump($data);die;*/

        if(isset($data["search"])){
            //如果有搜索值 条件已获得
            $db = new \yii\db\Query();
            
            $models = Goods::find()->where("name like :keywords")->addParams([':keywords'=>'%'.$_GET['search'].'%'])->limit($pager->limit)->offset($pager->offset)->all();
        }else{
            $models = Goods::find()->where(["status"=>1])->limit($pager->limit)->offset($pager->offset)->all();
        }


        return $this->render("list",["models"=>$models,"pager"=>$pager]);

    }

}