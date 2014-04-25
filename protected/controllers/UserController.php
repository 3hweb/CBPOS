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
        
        if(isset($_POST['UserModel']))
        {
            $model->attributes = $_POST['UserModel'];
            
            $model->update();
            
            if(!$model->hasErrors())
            {
                $this->dialogMessage = 'User was successfully updated.';
            }
            else
            {
                $this->dialogMessage = 'User was update failed';
            }

            $this->showDialog = true;
        }
        else
        {
            $model->attributes = $model->getUserInfo();
        }
        
        $this->render('_update',array(
            'model'=>$model,
        ));
    }
    
    public function hashPassword($account_code, $passcode)
    {
        return sha1($account_code . $passcode);
    }
    
    public function actionActivate()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $model = new UserModel();
            $model->account_id = $_GET['id'];
            $model->status = 1;
            
            $model->set_status();
            
            if(!$model->hasErrors())
            {
                $result_code = 0;
                $result_msg = "User activation successful";
            }
            else
            {
                $result_code = 1;
                $result_msg = "User activation failed";
            }

            echo CJSON::encode(array('result_code'=>$result_code, 'result_msg'=>$result_msg));
        }
    }
    
    public function actionDeactivate()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $model = new UserModel();
            $model->account_id = $_GET['id'];
            $model->status = 2;
            
            $model->set_status();
            
            if(!$model->hasErrors())
            {
                $result_code = 0;
                $result_msg = "User deactivation successful";
            }
            else
            {
                $result_code = 1;
                $result_msg = "User deactivation failed";
            }

            echo CJSON::encode(array('result_code'=>$result_code, 'result_msg'=>$result_msg));
        }
    }
    
    public function actionChangePass()
    {
        $model = new UserModel();        
        $model->account_id = $_GET['id'];
        $result = $model->getUserInfo();
        $account_code = $result['account_code'];
        $user = $result['last_name'] . " " . $result['first_name'];
        
        if(isset($_POST['UserModel']))
        {
            $model->account_code = $_POST['account_code'];
            $model->attributes = $_POST['UserModel'];
            $model->update_passcode();

            if(!$model->hasErrors())
            {
                $this->dialogMessage = 'Password changed successfully.';
            }
            else
            {
                $this->dialogMessage = 'Password changed failed.';
            }

            $this->showDialog = true;
        }
        
        $this->render('_changepass',array(
            'model'=>$model,
            'user'=>$user,
            'account_code'=>$account_code
        ));
    }
    
}
?>
