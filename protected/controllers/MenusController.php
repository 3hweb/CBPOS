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
    
    
    public function actionUpdateGroup()
    {
        $model = new MenuGroupModel();
        
        $id = $_GET['id'];
        $rawData = $model->getGroupMenuByID($id);
        
        if (isset($_POST['MenuGroupModel']))
        {
            $model->group_id = $id;
            $model->attributes = $_POST['MenuGroupModel'];
            
            if ($model->validate())
            {
                $retval = $model->updateMenuGroup();
                if ($retval)
                {
                    $this->title = 'SUCCESSFUL';
                    $this->message = 'Group menu successfully updated.';
                }
                else
                {
                    $this->title = 'NOTIFICATION';
                    $this->message = 'Error in updating group menu.';
                }
                
                $this->autoOpen = true;
            }
        }
                
        $this->render('group_edit', array('model'=>$model, 'data'=>$rawData));
    }
    
    
    public function actionItemIdx()
    {
        $model = new MenuItemsModel();
        
        $rawData = $model->getAllItemMenus();
        
        $dataProvider = new CArrayDataProvider($rawData, array(
                                                'keyField' => false,
                                                'pagination' => array(
                                                'pageSize' => 10,
                                            ),
                                ));
        $this->render('item_index',array(
            'dataProvider'=>$dataProvider,
        ));
    }
    
    
    public function actionAddItem()
    {
        $model = new MenuItemsModel();
        
        if (isset($_POST['MenuItemsModel']))
        {
            $model->attributes = $_POST['MenuItemsModel'];
            
            if ($model->validate())
            {
                $group_id =  $model->group_id;
                $item_name = $model->item_name;
                $item_price = $model->item_price;                
                $model->item_image_path = CUploadedFile::getInstance($model, 'item_image_path');
                
                $image_name_exploded = explode(".", $model->item_image_path->name);
                $file_format = $image_name_exploded[1]; // get the file format                
                $filename = strtolower(str_replace(" ", "-", $item_name)) . '.' . $file_format;
                $image_path = 'images/foodmenu/' . $filename;
                
                $retval = $model->insertMenuItem($group_id, $item_name, $item_price, $image_path);
                if ($retval)
                {
                    $model->item_image_path->saveAs(Yii::app()->basePath.'/../images/foodmenu/' . $filename);
                    
                    $this->title = 'SUCCESSFUL';
                    $this->message = 'Item menu successfully added.';
                }
                else
                {
                    $this->title = 'SUCCESSFUL';
                    $this->message = 'Error in inserting item menu.';
                }
                
                $this->autoOpen = true;
            }
        }
        
        $this->render('item_add', array('model'=>$model));
    }
    
    
    public function actionUpdateItem()
    {
        $model = new MenuItemsModel();
        
        $id = $_GET['id'];
        $rawData = $model->getItemMenuByID($id);
        
        if (isset($_POST['MenuItemsModel']))
        {
            $model->attributes = $_POST['MenuItemsModel'];
            
            if ($model->validate())
            {
                
            }
        }
        
        $this->render('item_edit', array('model'=>$model, 'data'=>$rawData));
    }
    
    
    public function actionUploadPhoto()
    {
        $model = new MenuItemsModel();
        
        $model->item_image_path = CUploadedFile::getInstance($model, 'item_image_path');
        $item_name = $_POST['filename'];
        
        $image_name_exploded = explode(".", $model->item_image_path->name);
        $file_format = $image_name_exploded[1]; // get the file format                
        $filename = strtolower(str_replace(" ", "-", $item_name)) . '.' . $file_format;
                
        $model->item_image_path->saveAs(Yii::app()->basePath.'/../images/foodmenu/' . $filename);
        
        echo true;
    }
}
?>
