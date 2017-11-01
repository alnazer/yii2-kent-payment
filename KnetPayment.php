<?php
namespace frontend\components;
use yii;
use app\kent\e24PaymentPipe;
require_once(__DIR__ . '/knet/com/aciworldwide/commerce/gateway/plugins/e24PaymentPipe.inc.php');
 
class KnetPayment {
    public $response_url;
    public $error_url;
    public $ammount;
    public $udf1 = "";
    public $udf2 = "";
    public $udf3 = "";
    public $udf4 = "";
    public $udf5 = "";
    public $action = 1;
    public $currency = 414;
    public $lang = "ARA";
    public $alias = "";
    public function run()
    {
        $Pipe = new e24PaymentPipe();
        $Pipe->setAction($this->action);
        $Pipe->setCurrency($this->currency);
        $Pipe->setLanguage($this->lang); //change it to "ARA" for arabic language
        $Pipe->setResponseURL($this->response_url); // set your respone page URL
        $Pipe->setErrorURL($this->error_url); //set your error page URL
        $Pipe->setAmt($this->ammount); //set the amount for the transaction
        $Pipe->setResourcePath(__DIR__."/knet/resource/"); //change the path where your resource file is
        $Pipe->setAlias($this->alias); //set your alias name here
        $Pipe->setTrackId(rand(45645,4446));//generate the random number here
        
        $Pipe->setUdf1($this->udf1); //set User defined value
        $Pipe->setUdf2($this->udf2); //set User defined value
        $Pipe->setUdf3($this->udf3); //set User defined value
        $Pipe->setUdf4($this->udf4); //set User defined value
        $Pipe->setUdf5($this->udf5); //set User defined value
        
        //get results
        if($Pipe->performPaymentInitialization()!= $Pipe->SUCCESS){
            $result['status'] = 'error';
            $result['url'] = '';
            $result['payment_id'] = $Pipe->getPaymentId();
            $result['msg'] = $Pipe->getErrorMsg();	
        }else {
            $payID = $Pipe->getPaymentId();
            $payURL = $Pipe->getPaymentPage();
            if(empty($payID)){
                $result['status'] = 'error';
                $result['url'] = '';
                $result['payment_id'] = $Pipe->getPaymentId();
                $result['msg'] = $payURL;
            }else{
                $result['status'] = 'success';
                $result['payment_id'] = $Pipe->getPaymentId();
                $result['url'] = $payURL."?PaymentID=".$payID;
            }
        }
        return json_encode($result);
    }
}
?>
