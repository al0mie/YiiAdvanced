<?php
namespace backend\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\ContentNegotiator;
use yii\rest\Controller;
use yii\web\Response;
use common\models\User;

class ApiController extends Controller
{
	const LOGIN = 'demo';
	const PASSWORD = 'demo';
	
	public function behaviors()
	{
	    $behaviors = parent::behaviors();
	    
    	$behaviors['authenticator'] = [
	        'class' => HttpBasicAuth::className(),
	        'auth' => [$this, 'auth']
	    ];
	    
	    $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
	        'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
	    ];
		
	    return $behaviors;
	}

	public function auth($username, $password)
    {
		/**
		 * It's only stub.
		 */
		if ($username == self::LOGIN && $password == self::PASSWORD) {
			return new User();
		}
		return false;
    }
}