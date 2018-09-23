<?php

namespace backend\models\search;


use backend\models\Admin;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use Yii;

class AdminSearch extends Admin
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          [['id'], 'integer'],
          [['username'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios(); // TODO: Change the autogenerated stub
    }

    public function search($query, $params)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
              'pageSize' => Yii::$app->request->get('limit', 15),
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this -> validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);
        $query->andFilterWhere(['like', 'username', $this->username]);
        $query->andWhere(['status' => self::STATUS_ACTIVE]);
        return $dataProvider;
    }
}