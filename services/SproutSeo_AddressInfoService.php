<?php

namespace Craft;


class SproutSeo_AddressInfoService extends BaseApplicationComponent
{

	public function saveAddressInfoByPost($namespace = 'address')
	{
		if (craft()->request->getPost($namespace) != null)
		{
			$addressInfo = craft()->request->getPost($namespace);

			$addressInfoModel = SproutSeo_AddressInfoModel::populateModel($addressInfo);

			if ($addressInfoModel->validate() == true && $this->saveAddressInfo($addressInfoModel))
			{
				return $addressInfoModel->id;
			}
		}

		return false;
	}

	public function saveAddressInfo(SproutSeo_AddressInfoModel $model, $source = '')
	{
		$result = false;

		$record = new SproutSeo_AddressInfoRecord;

		if (!empty($model->id))
		{
			$record = SproutSeo_AddressInfoRecord::model()->findById($model->id);

			if (!$record)
			{
				throw new Exception(Craft::t('No entry exists with the ID “{id}”', array('id' => $model->id)));
			}
		}

		if (!empty($model->getAttributes()))
		{
			foreach ($model->getAttributes() as $handle => $value)
			{
				$record->setAttribute($handle, $value);
			}
		}

		$transaction = craft()->db->getCurrentTransaction() === null ? craft()->db->beginTransaction() : null;

		if ($record->validate())
		{
			try
			{
				if ($record->save())
				{
					if ($transaction && $transaction->active)
					{
						$transaction->commit();
					}

					$model->setAttributes($record->getAttributes());

					$result = true;

					$eventParams = array(
						'model'  => $model,
						'source' => $source
					);

					$event = new Event($this, $eventParams);

					sproutSeo()->onSaveAdderssInfo($event);
				}
			}
			catch (\Exception $e)
			{
				if ($transaction && $transaction->active)
				{
					$transaction->rollback();
				}

				throw $e;
			}

		}
		else
		{
			$model->addErrors($record->getErrors());
		}

		if (!$result)
		{
			if ($transaction && $transaction->active)
			{
				$transaction->rollback();
			}
		}

		return $result;
	}

	public function getAddressById($id)
	{
		if ($record = SproutSeo_AddressInfoRecord::model()->findByPk($id))
		{
			return SproutSeo_AddressInfoModel::populateModel($record);
		}
		else
		{
			return new SproutSeo_AddressInfoModel();
		}
	}
}