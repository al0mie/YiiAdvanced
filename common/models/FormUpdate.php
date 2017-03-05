<?php

namespace common\models;

class FormUpdate extends User
{
	public $end_date;

	/**
	 * Event action after save, check subscription
	 *
	 * @param bool $insert
	 * @param array $changedAttributes
	 */
	public function afterSave($insert, $changedAttributes)
	{
		parent::afterSave($insert, $changedAttributes);

		if ($this->end_date === '' || $this->end_date === null) {
			UserSubscription::deleteAll(['user_id' => $this->id]);
		} else {

			/**
			 * convert to unix time
			 */
			$this->end_date = strtotime($this->end_date);

			/**
			 * add time before day end (59 + 59 * 60 + 23*60*60)
			 */
			$this->end_date += 86399;

			$subscription = UserSubscription::find()->where(['user_id' => $this->id])->one();
			if ($subscription === null) {
				$subscription = new UserSubscription();
				$subscription->user_id = $this->id;
			}
			$subscription->end_date = $this->end_date;
			$subscription->save();
		}
	}
}