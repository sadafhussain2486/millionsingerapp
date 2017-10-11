<?php

namespace app\controllers;

use Yii;
use app\models\Category;
use app\models\CategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        if(Yii::$app->user->isGuest)
        {
            $this->redirect(['site/login']);
        }
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];        
    }

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        /*$searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);*/
        $model = new CategorySearch();       
        $data=array();

        $indi_income=$model->find()->where(['type'=>'1','applied_for'=>'1'])->orderBy(['id'=>SORT_ASC])->all();
        $indi_expense=$model->find()->where(['type'=>'2','applied_for'=>'1'])->orderBy(['id'=>SORT_ASC])->all(); 

        $groupfamily_income=$model->find()->where(['type'=>'1','applied_for'=>'2'])->orderBy(['id'=>SORT_ASC])->all();
        $groupfamily_expense=$model->find()->where(['type'=>'2','applied_for'=>'2'])->orderBy(['id'=>SORT_ASC])->all();

        $data=['indiincome'=>$indi_income,'indiexpense'=>$indi_expense,'familyincome'=>$groupfamily_income,'familyexpense'=>$groupfamily_expense];
        echo $this->render('index',[
         'data' =>$data
        ]);
    }
    public function actionFamily()
    {
        $model = new CategorySearch();       
        $data=array();

        $groupfamily_income=$model->find()->where(['type'=>'1','applied_for'=>'2'])->orderBy(['id'=>SORT_ASC])->all();
        $groupfamily_expense=$model->find()->where(['type'=>'2','applied_for'=>'2'])->orderBy(['id'=>SORT_ASC])->all();

        $data=['familyincome'=>$groupfamily_income,'familyexpense'=>$groupfamily_expense];
        echo $this->render('family',[
         'data' =>$data
        ]);
    }
    public function actionCompany()
    {
        $model = new CategorySearch();       
        $data=array();

        $groupcompany_income=$model->find()->where(['type'=>'1','applied_for'=>'3'])->orderBy(['id'=>SORT_ASC])->all();
        $groupcompany_expense=$model->find()->where(['type'=>'2','applied_for'=>'3'])->orderBy(['id'=>SORT_ASC])->all();

        $data=['companyincome'=>$groupcompany_income,'companyexpense'=>$groupcompany_expense];
        echo $this->render('company',[
         'data' =>$data
        ]);
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {   
        $model = new Category();
        if ($model->load(Yii::$app->request->post()) ) 
        {
            $model->category_icon = "default.png";
            $model->category_type = 0;
            $model->type=Yii::$app->request->post('Category')['type'];
            $model->created_date=date("Y-m-d g:i:s");
            $model->modify_date=date("Y-m-d g:i:s");
            if($model->save())
            {
                if($_FILES['Category']['name']['category_icon']!="")
                {
                    if($_FILES['Category']['size']['category_icon']<=2097152)    //2097152=2MB
                    {
                        $model->category_icon = UploadedFile::getInstance($model,'category_icon');
                        $dt=$model->category_icon->saveAs('upload/category/'.time().'.'.$model->category_icon->extension);
                        $id = $model->getPrimaryKey();
                        if(!empty($dt))
                        {
                            $imagename=time().'.'.$model->category_icon->extension;
                            $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/category/'.$imagename;
                            ####################--START-CROP-IMAGE--####################
                            $imglocation= '.'.DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR.'category'.DIRECTORY_SEPARATOR.$imagename;
                            //IN LARGE
                            $targetfolder1='.'.DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR.'category'.DIRECTORY_SEPARATOR.'large'.DIRECTORY_SEPARATOR
                            $width1='256';
                            $height1='256';
                            Yii::$app->mycomponent->Imagecroper($imglocation,$targetfolder1,$imagename,$width1,$height1)
                            //IN MEDIUM
                            $targetfolder2='.'.DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR.'category'.DIRECTORY_SEPARATOR.'medium'.DIRECTORY_SEPARATOR
                            $width2='128';
                            $height2='128';
                            Yii::$app->mycomponent->Imagecroper($imglocation,$targetfolder2,$imagename,$width2,$height2)
                            //IN SMALL
                            $targetfolder3='.'.DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR.'category'.DIRECTORY_SEPARATOR.'small'.DIRECTORY_SEPARATOR
                            $width3='128';
                            $height3='128';
                            Yii::$app->mycomponent->Imagecroper($imglocation,$targetfolder3,$imagename,$width3,$height3)
                            ####################--END-CROP-IMAGE--######################
                        }
                        else
                        {
                            $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/category/default.png';
                        }       
                        $updatearr=array('category_icon' => $img);
                        $upd=$model->updateAll($updatearr, 'id = '.$id);
                    }
                }              
                return $this->redirect(['view', 'id' => $model->id]);
            }            
        }
        else 
        {
            return $this->render('create', [
                'model' => $model,
            ]);
        }        
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    

    public function actionUpdate($id)
    {        
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) 
        {
            $model->category_icon=$model['oldAttributes']["category_icon"];
            $model->modify_date=date("Y-m-d g:i:s");
            $model->save();            
            if($_FILES['Category']['name']['category_icon']!="")
            {   
                if($_FILES['Category']['size']['category_icon']<=2097152)    //2097152=2MB
                {     
                    $model->category_icon = UploadedFile::getInstance($model,'category_icon');        
                    $dt=$model->category_icon->saveAs('upload/category/'.time().'.'.$model->category_icon->extension);
                    $id = $model->getPrimaryKey();
                
                    if(!empty($dt))
                    {
                        $imagename=time().'.'.$model->category_icon->extension;
                        $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/category/'.$imagename;
                        ####################--START-CROP-IMAGE--####################
                        $imglocation= '.'.DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR.'category'.DIRECTORY_SEPARATOR.$imagename;
                        //IN LARGE
                        $targetfolder1='.'.DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR.'category'.DIRECTORY_SEPARATOR.'large'.DIRECTORY_SEPARATOR
                        $width1='256';
                        $height1='256';
                        Yii::$app->mycomponent->Imagecroper($imglocation,$targetfolder1,$imagename,$width1,$height1)
                        //IN MEDIUM
                        $targetfolder2='.'.DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR.'category'.DIRECTORY_SEPARATOR.'medium'.DIRECTORY_SEPARATOR
                        $width2='128';
                        $height2='128';
                        Yii::$app->mycomponent->Imagecroper($imglocation,$targetfolder2,$imagename,$width2,$height2)
                        //IN SMALL
                        $targetfolder3='.'.DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR.'category'.DIRECTORY_SEPARATOR.'small'.DIRECTORY_SEPARATOR
                        $width3='128';
                        $height3='128';
                        Yii::$app->mycomponent->Imagecroper($imglocation,$targetfolder3,$imagename,$width3,$height3)
                        ####################--END-CROP-IMAGE--######################
                        @unlink($model['oldAttributes']["category_icon"]);
                    }
                    else
                    {
                        $img = Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/category/default.jpg';
                    }                
                    $updatearr=array(
                                    'category_icon' => $img,
                                );
                    $upd=$model->updateAll($updatearr, 'id = '.$id); 
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } 
        else 
        {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actioncategory()
    {
        $model = new Category();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                // form inputs are valid, do something here
                return;
            }
        }
        return $this->render('category', [
            'model' => $model,
        ]);
    }
}
