<?php

namespace common\models;

class FormUpdate extends User
{
    public $end_date;

    /**
     * add rule for end date
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        return array_merge($rules, [
            [['end_date'], 'date', 'format' => 'dd-MM-yyyy'],
        ]);
    }

    /**
     * Event action after save, check subscription
     *
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $subscription = $this->user_subscription;

        /**
         * if date is empty, remove subscribe
         */
        if (!$this->end_date && $subscription) {
            $subscription->delete();
        } else {

            /**
             * convert to unix time
             */
            $this->end_date = strtotime($this->end_date);

            /**
             * add time before day end (59 + 59 * 60 + 23*60*60)
             */
            $this->end_date += 86399;

            /**
             * if date exists, create subscribe
             */
            if ($subscription === null) {
                $subscription = new UserSubscription();
                $subscription->user_id = $this->id;
            }
            $subscription->end_date = $this->end_date;
            $subscription->save();
        }
    }
}