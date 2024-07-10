<?php
namespace app\controllers;

use Yii;
use app\models\User;
use app\models\SignupForm;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'signup', 'change-password', 'delete-account'],
                        'allow' => true,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Список всех пользователей.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Просмотр одного пользователя.
     *
     * @param int $id
     * @return string
     * @throws NotFoundHttpException, если модель не найдена
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Создание нового пользователя.
     *
     * Если создание успешно, перенаправляем на страницу просмотра.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User();

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->setPassword($model->password_hash); // Используем атрибут password_hash для установки пароля
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Обновление существующего пользователя.
     *
     * Если обновление успешно, перенаправляем на страницу просмотра.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException, если модель не найдена
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->setPassword($model->password_hash); // Используем атрибут password_hash для установки пароля
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
}

    /**
     * Удаление существующего пользователя.
     *
     * Если удаление успешно, перенаправляем на страницу списка пользователей.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException, если модель не найдена
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Регистрация нового пользователя.
     *
     * Если регистрация успешна, перенаправляем на главную страницу.
     * @return string|\yii\web\Response
     */
    public function actionSignup()
    {
        $model = new SignupForm();

        if ($this->request->isPost && $model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                Yii::$app->session->setFlash('success', 'Registration successful.');
                return $this->redirect(['site/index']); // Перенаправляем на другую страницу после регистрации
            } else {
                Yii::$app->session->setFlash('error', 'Failed to register.');
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Изменение пароля пользователя.
     *
     * @return string|\yii\web\Response
     */
    public function actionChangePassword()
    {
        $id = Yii::$app->user->identity->id; // Получаем ID текущего пользователя
        $model = $this->findModel($id); // Находим модель пользователя по ID

        if ($model->load(Yii::$app->request->post())) {
            // Устанавливаем новый пароль только если он передан и не пустой
            if (!empty($model->password)) {
                $model->setPassword($model->password); // Устанавливаем новый пароль с помощью метода модели
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Password changed successfully.');
                return $this->redirect(['site/index']); // Перенаправляем на другую страницу после успешного обновления
            } else {
                Yii::$app->session->setFlash('error', 'Failed to change password.');
            }
        }

        return $this->render('change-password', [
            'model' => $model,
        ]);
    }

    /**
     * Удаление аккаунта текущего пользователя.
     *
     * @return \yii\web\Response
     */
    public function actionDeleteAccount()
    {
        $id = Yii::$app->user->identity->id; // Получаем ID текущего пользователя
        $model = $this->findModel($id); // Находим модель пользователя по ID

        // Удаляем пользователя
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Your account has been deleted.');
            Yii::$app->user->logout(); // Выход текущего пользователя
            return $this->redirect(['site/index']); // Перенаправляем на другую страницу после удаления аккаунта
        } else {
            Yii::$app->session->setFlash('error', 'Failed to delete your account.');
            return $this->redirect(['site/index']); // Перенаправляем на другую страницу в случае ошибки
        }
    }

    /**
     * Поиск модели пользователя по ее первичному ключу.
     *
     * Если модель не найдена, выбрасывается исключение 404 HTTP.
     * @param int $id
     * @return User загруженная модель
     * @throws NotFoundHttpException, если модель не найдена
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
