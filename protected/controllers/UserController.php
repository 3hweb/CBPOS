<?php

/*
 * @author : owliber
 * @date : 2014-04-21
 */

class UserController extends Controller
{
    public $dialogMessage;
    public $showDialog = false;
    
    public function actionIndex()
    {
        $model = new UserModel();
        $rawData = $model->getAllUsers();
        $dataProvider = new CArrayDataProvider($rawData, array(
                                                'keyField' => false,
                                                'pagination' => array(
                                                'pageSize' => 10,
                                            ),
                                ));
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }
    
    public function actionAdd()
    {
        $model = new UserModel();
        $model->account_code = $model->getMaxAccountCode();
        
        if(isset($_POST['UserModel']))
        {
            $model->attributes = $_POST['UserModel'];
            
            if($model->validate())
            {
                $model->save();
                
                if(!$model->hasErrors())
                {
                    $this->dialogMessage = 'New user was successfully created';
                }
                else
                {
                    $this->dialogMessage = 'New user creation has failed.';
                }
                
                $this->showDialog = true;
            }
            else
            {
                $this->dialogMessage = 'Ooops, something went wrong!';
                $this->showDialog = true;
            }
        }
        $this->render('_newuser',array(
            'model'=>$model,
        ));
    }
    
    public function actionUpdate()
    {
        $model = new UserModel();
        $model->account_id = $_GET['id'];
        $model->attributes = $model->getUserInfo();
        $this->render('_update',array(
            'model'=>$model,
        ));
    }
    
    public function hashPassword($account_code, $passcode)
    {
        return sha1($account_code . $passcode);
    }
    
    
}
?>
