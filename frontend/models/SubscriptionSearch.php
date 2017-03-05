<?php

namespace frontend\models;

use yii\data\ActiveDataProvider;
use common\models\User;

class SubscriptionSearch extends User
{
    public $fullName;
    public $end_date;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['login', 'password', 'email', 'name', 'surname' ,'middle_name'], 'safe'],
            [['fullName'], 'safe'],
            [['end_date'], 'safe']
        ];
    }

    protected function addCondition($query, $attribute, $partialMatch = false)
    {
        if (($pos = strrpos($attribute, '.')) !== false) {
            $modelAttribute = substr($attribute, $pos + 1);
        } else {
            $modelAttribute = $attribute;
        }

        $value = $this->$modelAttribute;

        if (trim($value) === '') {
            return;
        }

        $attribute = "users.$attribute";

        if ($partialMatch) {
            $query->andWhere(['like', $attribute, $value]);
        } else {
            $query->andWhere([$attribute => $value]);
        }
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        /**
         * sort settings
         */
        $dataProvider->setSort([
            'attributes' => [
                'id',
                'fullName' => [
                    'asc' => ['name' => SORT_ASC, 'surname' => SORT_ASC, 'middle_name' => SORT_ASC],
                    'desc' => ['name' => SORT_DESC, 'surname' => SORT_DESC, 'middle_name' => SORT_DESC],
                    'label' => 'fullName',
                    'default' => SORT_ASC
                ],
                'end_date' => [
                    'asc' => ['user_subscription.end_date' => SORT_ASC],
                    'desc' => ['user_subscription.end_date' => SORT_DESC],
                    'label' => 'Expire date',
                    'default' => SORT_ASC
                ],
                'email',
                'login'
            ]
        ]);


        if (!($this->load($params) && $this->validate())) {

            /**
             * enable sorting by end_date on initial loading of the grid
             */
            $query->joinWith(['user_subscription']);
            return $dataProvider;
        }

        $this->addCondition($query, 'id');
        $this->addCondition($query, 'login', true);
        $this->addCondition($query, 'email', true);

        /**
         * filter by full name
         */
        if ($this->fullName) {
            $query->andWhere('CONCAT_WS(" ", surname, name, middle_name) LIKE "%' . $this->fullName . '%"');
        }
        /**
         * Filter by date
         */
        if ($this->end_date) {
            $this->end_date = strtotime($this->end_date) + 86399;
            $query->joinWith(['user_subscription' => function ($q) {
                $q->where('user_subscription.end_date = "' . $this->end_date . '"');
            }]);
        }
        return $dataProvider;
    }
}
