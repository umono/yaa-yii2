<?php

    namespace app\common\models\photo;

    use app\common\models\Model;
    use Yii;

    /**
     * This is the model class for table "{{%photo}}".
     *
     * @property int    $id
     * @property string $path       路劲
     * @property string $title      文件名
     * @property string $url        图片的URL
     * @property int    $user_id    用户ID
     * @property string $type_id    关联类型的ID
     * @property string $type_model 类型类
     * @property int    $status     状态 0 无用 1使用
     * @property int    $region     本地9
     * @property string $version    当前提交的信息作为唯一标识 使用状态
     * @property string $created_at 创建时间
     * @property string $updated_at 修改时间
     */
    class Photo extends Model
    {
        /**
         * {@inheritdoc}
         */
        public static function tableName()
        {
            return '{{%photo}}';
        }

        /**
         * {@inheritdoc}
         */
        public function rules()
        {
            return [
                [['user_id', 'status', 'region'], 'integer'],
                [['created_at', 'updated_at'], 'safe'],
                [['path', 'title', 'url', 'type_model', 'version'], 'string', 'max' => 255],
                [['type_id'], 'string', 'max' => 50],
            ];
        }

        /**
         * {@inheritdoc}
         */
        public function attributeLabels()
        {
            return [
                'id'         => 'ID',
                'path'       => '路劲',
                'title'      => '文件名',
                'url'        => '图片的URL',
                'user_id'    => '用户ID',
                'type_id'    => '关联类型的ID',
                'type_model' => '类型类',
                'status'     => '状态',
                'region'     => '用户端1， 商户端9',
                'version'    => '当前提交的信息作为唯一标识 使用状态',
                'created_at' => '创建时间',
                'updated_at' => '修改时间',
            ];
        }

        // 上传的话直接建立
        public static function create($param, $path)
        {
            $model = new Photo();
            $model->load($param, '');
            $model->path       = $path;
            $model->region     = 9;
            $model->created_at = date('Y-m-d H:i:s');
            $model->updated_at = date('Y-m-d H:i:s');
            $model->status     = 0;
            $model->save();
        }

        // 图片所属变化
        public static function change($url, string $version, $type_id, string $type_model, $user_id)
        {
            $type_id = (string)$type_id;
            if (empty($url)) {
                self::error("请核实图片链接");
            }

            $name = substr($url, -36);

            $photo = Photo::findOne(['title' => $name]);
            $time  = date('Y-m-d H:i:s');
            if (empty($photo)) {
                if (empty($user_id)) {
                    return '';
                }
                $model             = new Photo();
                $model->url        = $url;
                $model->type_id    = $type_id;
                $model->type_model = $type_model;
                $model->title      = $name;
                $model->user_id    = $user_id;
                $model->region     = 9;
                $model->version    = $version;
                $model->created_at = $time;
                $model->updated_at = $time;
                $model->status     = 1;
                $model->save();
                unset($model);
            } else {
                $photo->status     = 1;
                $photo->url        = $url;
                $photo->type_id    = $type_id;
                $photo->type_model = $type_model;
                $photo->version    = $version;
                $photo->updated_at = $time;
                $photo->save();
                $type_model = str_replace('\\', "\\\\\\\\", $type_model);
                $where      = 'status = 1 ' . 'and type_id = \'' . $type_id . '\'' . ' and type_model like "%' . $type_model . '%" and version <> "' . $version . '"';
                Yii::$app->db->createCommand()
                    ->update(
                        Photo::tableName(),
                        ['status' => 0, 'version' => '-1', 'updated_at' => date('Y-m-d H:i:s')],
                        $where)
                    ->execute();
            }
            unset($photo);
        }

        // 变换状态
        public static function status($url, $type_id, $type_model)
        {
            /* @var Photo $photo */
            $photo = Photo::find()->where(['like', 'url', $url])
                ->andWhere(['type_id' => $type_id, 'type_model' => $type_model])
                ->one();
            if (!empty($photo)) {
                $photo->status     = 0;
                $photo->updated_at = date('Y-m-d H:i:s');
                $photo->save();
            }
            unset($photo);
        }
    }
