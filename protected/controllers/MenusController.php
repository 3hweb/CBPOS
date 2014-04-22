<?php

/**
 * @author Noel Antonio
 * @date 04-21-2014
 */

class MenusController extends Controller
{
    public $layout = "column1";
    public $autoOpen = false;
    public $message = '';
    public $title = '';
    
    
    public function actionIndex()
    {
        $this->render('index');
    }
    
    
    public function actionGroupIdx()
    {
        $model = new MenuGroupModel();
        
        $rawData = $model->getAllGroupMenus();
        
        $dataProvider = new CArrayDataProvider($rawData, array(
                                                'keyField' => false,
                                                'pagination' => array(
                                                'pageSize' => 10,
                                            ),
                                ));
        $this->render('group_index',array(
            'dataProvider'=>$dataProvider,
        ));
    }
    
    
    public function actionAddGroup()
    {
        $model = new MenuGroupModel();
        
        if (isset($_POST['MenuGroupModel']))
        {
            $model->attributes = $_POST['MenuGroupModel'];
            
            if ($model->validate())
            {
                $retval = $model->insertMenuGroup();
                if ($retval)
                {
                    $this->title = 'SUCCESSFUL';
                    $this->message = 'Group menu successfully added.';
                }
                else
                {
                    $this->title = 'NOTIFICATION';
                    $this->message = 'Error in inserting group menu.';
                }
                
                $this->autoOpen = true;
            }
        }
                
        $this->render('group_add', array('model'=>$model));
    }
}
?>
