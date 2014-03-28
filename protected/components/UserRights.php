<?php

/*
 * @author : owliber
 * @date : 2014-03-28
 */

class UserRights extends CWebUser
{
   
    public function hasUserAccess()
    {
        $model = new AccessRights();
        
        
        if(!$model->checkUserAccess($this->accountType()) || Yii::app()->user->isGuest)
            return false;
        else
            return true;
            
    }
    
    public function accountType()
    {
        return Yii::app()->session['account_type_id'];
    }
    
    public function isAdmin()
    {
        if($this->accountType() == 1)
            return true;
        else
            return false;
    }
    
    public function getId() {
        return Yii::app()->session['account_id'];
    }
    
    public function getAccountName()
    {
        $model = new Accounts();
        $member_name = $model->getAccountName($this->getId());
        return $member_name;
    }
    
    public function get_default_page()
    {
        
    }
}
?>
