Knet Payment Via Yii 2.0 framework
==================================
this is Knet payment type via yii 2.0

Installation
------------

unzip all files and insert int to Path frontend/components/
if folder components not found you can create


Usage
-----

Once the extension is installed, simply use it in your code by  :

```
1- add your resource.cgn file in to Path knet\resource
```
How you can use this class

2-  in your controller paste this code 
```
use frontend\components\KnetPayment;
    /**
     * Do knet paymet action .
     *
     * @return mixed
     */
    public function actionPayment()
    {
        $knet = new KnetPayment();
        $knet->response_url = Url::to(['site/knetresponce'],'https'); // back response
        $knet->error_url = Url::to(['site/kneterror'],'https'); // back error
        $knet->ammount = 10; // your ammount or cost you can use decimal 10.33
        $knet->udf1 = "";
        $knet->udf2 = "";
        $knet->udf3 = "";
        $knet->udf4 = "";
        $knet->udf5 = "";
        $knet->action = 1;/leav it
        $knet->currency = 414;//Kw dinar
        $knet->lang = "ARA"; //default arabic lang
        $knet->alias = "your knet alias";
        $result = $knet->run(); // return json data
        $result = json_decode($result);
        
        if($result->status == 'success'){
            // redirect to knet url $result->url;
            $this->redirect($result->url);
        }else{
          // Display error here
        }
    }
```
in SiteController.php or other controller you choose you must add to actions  
```
    /**
     *knet Responce result .
     *
     * @return mixed
     */
    public function actionKnetResponce()
    {
        // Do your action here
        
        
        $PaymentID = $_POST['PaymentID']; // Reads the value of the Payment ID passed by GET request by the user.
        $result = $_POST['Result']; // Reads the value of the Result passed by GET request by the user.
        $postdate = $_POST['PostDate']; // Reads the value of the PostDate passed by GET request by the user.
        $tranid = $_POST['TranID']; // Reads the value of the TranID passed by GET request by the user.
        $auth = $_POST['Auth']; // Reads the value of the Auth passed by GET request by the user.
        $ref = $_POST['Ref']; // Reads the value of the Ref passed by GET request by the user.
        $trackid = $_POST['TrackID'];  // Reads the value of the TrackID passed by GET request by the user.
        $udf1 = $_POST['UDF1'];  // Reads the value of the UDF1 passed by GET request by the user.
        $udf2 = $_POST['UDF2'];  // Reads the value of the UDF1 passed by GET request by the user.
        $udf3 = $_POST['UDF3'];  // Reads the value of the UDF1 passed by GET request by the user.
        $udf4 = $_POST['UDF4'];  // Reads the value of the UDF1 passed by GET request by the user.
        $udf5 = $_POST['UDF5'];  // Reads the value of the UDF1 passed by GET request by the user.
        
        echo "REDIRECT= Url::to(['site/knetresult',$_POST],'https');
    }
     /**
     *knet result Page .
     *
     * @return mixed
     */
    public function actionKnetResult()
    {
      // display result page
    }
    
    /**
     *knet Error result .
     *
     * @return mixed
     */
    public function actionknetError()
    {
      $PaymentID = $_GET['PaymentID'];
      //Display error page
    }
        /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['knetresponce', 'kneterror','knetresult'],
                'rules' => [
                    [
                        'actions' => ['knetresponce','kneterror','knetresult'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }
```

if Payment operation success return json code 
```
{"status":"success","payment_id":"xxxxxxxxx650","url":"https:\/\/www.knetpay.com.kw:443\/CGW\/hppaction?formAction=com.aciworldwide.commerce.gateway.payment.action.HostedPaymentPageAction&?PaymentID=xxxxxxxxx650"}
```
else if Payment operation fail return json code 
```
{"status":"error","payment_id":"","url":"","msg":"RROR - CGW000186-Tran Amount Invalid"}
---------------------------
msg is knet responce error
```

 
