<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', ['as' => 'home.sales', 'uses' => 'Sales\SalesController@main']);

Auth::routes();

//Route::get('/home', 'HomeController@index');

Route::get('promo', function () {
    return redirect('http://mon.net.br/12t3j?src=testeFaceAgosto17');
});

Route::get('/inscricao',['as'=>'inscricao.register','uses' => 'Sales\SalesController@index']);
Route::get('/404',['as'=>'not.found','uses' => 'Dashboard\HomesController@notFound']);
Route::get('/500',['as'=>'not.found','uses' => 'Dashboard\HomesController@error']);


//+
Route::group(['middleware' => ['web']], function () {

    /**
    * Painel Routes
    */

    Route::group(['prefix'=>'blog'], function(){


        Route::group(['prefix' => 'painel'], function () {

            /**
            * Login
            */
            Route::get('login',  ['as' => 'painel.auth.login',  'uses' => 'Blog\Back\AuthController@authenticate']);
            Route::post('login', ['as' => 'painel.auth.login',  'uses' => 'Blog\Back\AuthController@login']);
            Route::get('logout', ['as' => 'painel.auth.logout', 'uses' => 'Blog\Back\AuthController@logout']);

            /**
            * Password reset
            */
            Route::get('redefinir-senha', ['as' => 'painel.reminders.reminder', 'uses' => 'Blog\Back\RemindersController@reminder']);
            Route::post('redefinir-senha', ['as' => 'painel.reminders.reminder', 'uses' => 'Blog\Back\RemindersController@remind']);
            Route::get('redefinir-senha/{id}/{code}', ['as' => 'painel.reminders.reset', 'uses' => 'Blog\Back\RemindersController@reset'])->where('id', '\d+');
            Route::post('redefinir-senha/{id}/{code}', ['as' => 'painel.reminders.reset', 'uses' => 'Blog\Back\RemindersController@processReset'])->where('id', '\d+');

            /**
            * If Logged
            */
            Route::group(['middleware' => ['sentinel.auth']], function () {

                /**
                * Dashboard
                */
                Route::get('/', ['as' => 'painel.dashboard.index', 'uses' => 'Blog\Back\DashboardController@index']);

                /**
                * Uploads
                */
                Route::group(['prefix' => 'images'], function() {
                    Route::get('/', ['as' => 'painel.images.index', 'uses' => 'Blog\Back\ImagesController@index']);
                    Route::post('adicionar', ['as' => 'painel.images.create', 'uses' => 'Blog\Back\ImagesController@store']);
                    Route::delete('excluir/{id}', ['as' => 'painel.images.destroy', 'uses' => 'Blog\Back\ImagesController@destroy']);
                });

                /**
                * Account
                */
                Route::get('perfil', ['as' => 'painel.account.index', 'uses' => 'Blog\Back\AccountController@index']);
                Route::get('perfil/editar', ['as' => 'painel.account.edit', 'uses' => 'Blog\Back\AccountController@edit']);
                Route::put('perfil/editar', ['as' => 'painel.account.edit', 'uses' => 'Blog\Back\AccountController@update']);

                /**
                * Contacts
                */
                Route::group(['prefix' => 'mensagens'], function() {
                    Route::get('/', ['as' => 'painel.contacts.index', 'uses' => 'Blog\Back\ContactsController@index']);
                    Route::get('{id}', ['as' => 'painel.contacts.show', 'uses' => 'Blog\Back\ContactsController@show']);
                });



                /**
                * Posts
                */
                Route::group(['prefix' => 'posts'], function() {
                    Route::get('/', ['as' => 'painel.posts.index', 'uses' => 'Blog\Back\PostsController@index']);
                    Route::get('/visualizar/{id}', ['as' => 'painel.posts.show', 'uses' => 'Blog\Back\PostsController@show']);
                    Route::get('adicionar', ['as' => 'painel.posts.create', 'uses' => 'Blog\Back\PostsController@create']);
                    Route::post('adicionar', ['as' => 'painel.posts.create', 'uses' => 'Blog\Back\PostsController@store']);
                    Route::get('editar/{id}', ['as' => 'painel.posts.edit', 'uses' => 'Blog\Back\PostsController@edit']);
                    Route::put('editar/{id}', ['as' => 'painel.posts.edit', 'uses' => 'Blog\Back\PostsController@update']);
                    Route::get('excluir/{id}', ['as' => 'painel.posts.destroy', 'uses' => 'Blog\Back\PostsController@destroy']);
                });

                /**
                * Categories
                */
                Route::group(['prefix' => 'categorias'], function() {
                    Route::get('/', ['as' => 'painel.categories.index', 'uses' => 'Blog\Back\CategoriesController@index']);
                    Route::get('adicionar', ['as' => 'painel.categories.create', 'uses' => 'Blog\Back\CategoriesController@create']);
                    Route::post('adicionar', ['as' => 'painel.categories.create', 'uses' => 'Blog\Back\CategoriesController@store']);
                    Route::get('editar/{id}', ['as' => 'painel.categories.edit', 'uses' => 'Blog\Back\CategoriesController@edit']);
                    Route::put('editar/{id}', ['as' => 'painel.categories.edit', 'uses' => 'Blog\Back\CategoriesController@update']);
                    Route::get('excluir/{id}', ['as' => 'painel.categories.destroy', 'uses' => 'Blog\Back\CategoriesController@destroy']);
                });

                /**
                * Pages
                */
                Route::group(['prefix' => 'paginas'], function() {
                    Route::get('/', ['as' => 'painel.pages.index', 'uses' => 'Blog\Back\PagesController@index']);
                    Route::get('adicionar', ['as' => 'painel.pages.create', 'uses' => 'Blog\Back\PagesController@create']);
                    Route::post('adicionar', ['as' => 'painel.pages.create', 'uses' => 'Blog\Back\PagesController@store']);
                    Route::get('editar/{id}', ['as' => 'painel.pages.edit', 'uses' => 'Blog\Back\PagesController@edit']);
                    Route::put('editar/{id}', ['as' => 'painel.pages.edit', 'uses' => 'Blog\Back\PagesController@update']);
                    Route::get('excluir/{id}', ['as' => 'painel.pages.destroy', 'uses' => 'Blog\Back\PagesController@destroy']);
                });

                /**
                * Analytics
                */
                Route::group(['prefix' => 'acessos'], function() {
                    Route::get('/', ['as' => 'painel.analytics.index', 'uses' => 'Blog\Back\AnalyticsController@index']);
                });

                /**
                * Users
                */
                Route::group(['prefix' => 'usuarios'], function() {
                    Route::get('/', ['as' => 'painel.users.index', 'uses' => 'Blog\Back\UsersController@index']);
                    Route::get('adicionar', ['as' => 'painel.users.create', 'uses' => 'Blog\Back\UsersController@create']);
                    Route::post('adicionar', ['as' => 'painel.users.create', 'uses' => 'Blog\Back\UsersController@store']);
                    Route::get('editar/{id}', ['as' => 'painel.users.edit', 'uses' => 'Blog\Back\UsersController@edit']);
                    Route::put('editar/{id}', ['as' => 'painel.users.edit', 'uses' => 'Blog\Back\UsersController@update']);
                    Route::get('excluir/{id}', ['as' => 'painel.users.destroy', 'uses' => 'Blog\Back\UsersController@destroy']);
                });

                /**
                * Roles
                */
                Route::group(['prefix' => 'grupos'], function() {
                    Route::get('/', ['as' => 'painel.roles.index', 'uses' => 'Blog\Back\RolesController@index']);
                    Route::get('adicionar', ['as' => 'painel.roles.create', 'uses' => 'Blog\Back\RolesController@create']);
                    Route::post('adicionar', ['as' => 'painel.roles.create', 'uses' => 'Blog\Back\RolesController@store']);
                    Route::get('editar/{id}', ['as' => 'painel.roles.edit', 'uses' => 'Blog\Back\RolesController@edit']);
                    Route::put('editar/{id}', ['as' => 'painel.roles.edit', 'uses' => 'Blog\Back\RolesController@update']);
                    Route::get('excluir/{id}', ['as' => 'painel.roles.destroy', 'uses' => 'Blog\Back\RolesController@destroy']);
                });

                /**
                * Logs
                */
                Route::group(['prefix' => 'logs'], function() {
                    Route::get('/', ['as' => 'painel.logs.index', 'uses' => 'Blog\Back\LogsController@index']);
                    Route::get('/excluir', ['as' => 'painel.logs.destroy', 'uses' => 'Blog\Back\LogsController@destroy']);
                });

            });

        });
    });

    /**
    * Home
    */
    Route::get('/blog', ['as' => 'homes.index', 'uses' => 'Blog\Front\HomesController@index']);

    /**
    * Conversions
    */
    Route::post('/conversao/enviar', ['as' => 'conversions.store', 'uses' => 'Blog\Front\ConversionsController@store']);

    /**
    * Ratings
    */
    Route::group(['prefix' => 'avaliacoes'], function() {
        Route::post('nota', ['as' => 'ratings.index', 'uses' => 'Blog\Front\RatingsController@view']);
        Route::post('avaliar', ['as' => 'ratings.create', 'uses' => 'Blog\Front\RatingsController@store']);
    });

    /**
    * Posts
    */
    Route::get('/posts/buscar', ['as' => 'posts.search', 'uses' => 'Blog\Front\PostsController@search']);
    Route::get('/posts/recentes',['as' => 'posts.recent', 'uses' => 'Blog\Front\PostsController@index']);
    Route::get('/posts/populares',['as' => 'posts.popular', 'uses' => 'Blog\Front\PostsController@popular']);
    Route::get('/posts/{category}/{post}/{id}',['as' => 'posts.view', 'uses' => 'Blog\Front\PostsController@view']);
    Route::get('/categoria/{category}',['as' => 'posts.category', 'uses' => 'Blog\Front\PostsController@category']);
    Route::get('/autor/{user}',['as' => 'posts.author', 'uses' => 'Blog\Front\PostsController@author']);
    Route::get('/tag/{tag}',['as' => 'posts.tag', 'uses' => 'Blog\Front\PostsController@tag']);

    /**
    * Sitemaps
    */
    Route::get('/sitemaps', ['as' => 'sitemaps.index', 'uses' => 'Blog\Front\SitemapsController@index']);

});

    /**
    *  Site Routes
    */
Route::group(['prefix' => 'dashboard'], function() {

    Route::get('/logout', ['as' => 'dashboard.logout', 'uses' => 'Dashboard\AuthController@logout']);

    Route::get('/login', ['as' => 'dashboard.login.index', 'uses' => 'Dashboard\AuthController@index']);
    Route::post('/login', ['as' => 'dashboard.login', 'uses' => 'Dashboard\AuthController@login']);
    Route::get('/register', ['as' => 'dashboard.register', 'uses' => 'Auth\RegisterController@registerNormal']);
    Route::post('/register', ['as' => 'dashboard.register', 'uses' => 'Auth\RegisterController@registerNormal']);
//    Route::get('/register-promo', ['as' => 'dashboard.register', 'uses' => 'Auth\RegisterController@registerWithRDStation']);
//    Route::post('/register-promo', ['as' => 'dashboard.register', 'uses' => 'Auth\RegisterController@registerWithRDStation']);
    Route::get('/forgot-password', 'Dashboard\AuthController@forgotPassword');


    Route::get('/redirect', ['as' => 'dashboard.fblogin', 'uses' => 'Auth\SocialAuthController@redirect']);
    Route::get('/callback', ['as' => 'dashboard.fbregister', 'uses' => 'Auth\SocialAuthController@callback']);

    Route::get('contato','Dashboard\ContactController@index');
    Route::post('contato','Dashboard\ContactController@postContact');


    Route::group(['middleware' => 'api.auth'], function(){
        Route::group(['middleware' => 'user.level'], function(){
            // Home
            Route::get('/',        ['as' => 'dashboard.homes.index', 'uses' => 'Dashboard\HomesController@index']);
            Route::get('/default', ['as' => 'dashboard.homes.default', 'uses' => 'Dashboard\HomesController@default']);
            Route::get('/tutorial', 'Dashboard\HomesController@tutorial');

            // Filter
            Route::get('/filtro',  ['as' => 'dashboard.filter.index', 'uses' => 'Dashboard\FilterController@index']);
            Route::post('/filtro', ['as' => 'dashboard.filter.filter', 'uses' => 'Dashboard\FilterController@filter']);
            // Questions
            Route::get('/questoes',                     ['as' => 'dashboard.question.index', 'uses' => 'Dashboard\QuestionController@index']);
            Route::get('/result/{idsubject}/{idtopic}', ['as' => 'dashboard.question.result', 'uses' => 'Dashboard\ResultController@result']);
            Route::get('/get-questions/{id}', 'Dashboard\QuestionController@questions');
            Route::post('/question',                    ['as' => 'dashboard.filter.filter', 'uses' => 'Dashboard\FilterController@filter']);

            // Discursive
            Route::get('/discursivas', ['as' => 'dashboard.discursive.index', 'uses' => 'Dashboard\DiscursiveController@index']);
            Route::get('/questoes-discursivas/{id},{startYear},{endYear},{hasFeedback},{type}','Dashboard\DiscursiveController@questions');
            Route::get('/discursivas/resolved','Dashboard\DiscursiveController@resolvedQuestions');



            Route::get('/send-report', 'Dashboard\QuestionController@sendReport');

            Route::get('/controle', 'Dashboard\StudyScheduleController@index');
            Route::get('/controle/disponibilidade', 'Dashboard\StudyScheduleController@availability');
            Route::get('/controle/disciplinas', 'Dashboard\StudyScheduleController@subject');
            Route::get('/controle/historico', 'Dashboard\StudyScheduleController@historic');
            Route::get('/controle/ciclo', 'Dashboard\StudyScheduleController@cycle');

            Route::get('/simulado/landing', ['as'=> 'dashboard.quiz.landing', 'uses' => 'Dashboard\QuizController@landing']);
            Route::get('/simulado/{subjectId}', ['as' => 'dashboard.quiz.index', 'uses' => 'Dashboard\QuizController@getQuizBySubject']);
    //                    Route::get('/simulado/resultado/{subjectId}', ['as' => 'dashboard.quiz.result', 'uses' => 'Dashboard\QuizController@result']);
            Route::get('/simulado/resultado/{subjectName}', ['as' => 'dashboard.quiz.result', 'uses' => 'Dashboard\QuizController@result']);



            /**
            * Courses
            */
            Route::group(['prefix' => 'materias'], function() {
                Route::get('/', ['as' => 'dashboard.courses.index', 'uses' => 'Dashboard\CoursesController@index']);
                Route::get('{subjectId}', ['as' => 'dashboard.courses.show', 'uses' => 'Dashboard\CoursesController@show']);
                Route::get('{subjectId}/{lesson}', ['as' => 'dashboard.lessons.show', 'uses' => 'Dashboard\LessonsController@show']);
                Route::get('disciplina/{subject}/{user}',['as' => 'dashboard.courses.show2', 'uses' => 'Dashboard\CoursesController@showBySubject']);
            });
        });

        // Profile
        Route::get('/perfil',             ['as' => 'dashboard.profile',            'uses' => 'Dashboard\ProfileController@index']);
        Route::get('/perfil/senha',       ['as' => 'dashboard.profile.password',   'uses' => 'Dashboard\ProfileController@password']);
        Route::get('/perfil/pagamento',   ['as' => 'dashboard.profile.payment',    'uses' => 'Dashboard\ProfileController@payment']);
        Route::get('/perfil/historico',   ['as' => 'dashboard.profile.history',    'uses' => 'Dashboard\ProfileController@history']);
        Route::post('/perfil/avatar',     ['as' => 'dashboard.profile.avatar',     'uses' => 'Dashboard\ProfileController@avatar']);
        Route::post('/perfil/update',     ['as' => 'dashboard.profile.update',     'uses' => 'Dashboard\ProfileController@update']);
        Route::post('/perfil/update-pwd', ['as' => 'dashboard.profile.update-pwd', 'uses' => 'Dashboard\ProfileController@passwordUpdate']);



    });
});

// Password
Route::get('/change-page/{token}', 'Dashboard\AuthController@changePassword');

// Terms
Route::get('/termos', 'Dashboard\HomesController@terms');

/**
* Payment
*/
Route::group(['prefix' => 'inscricao', 'middleware' => 'api.auth'],function(){
    Route::get('/planos',    'Sales\SalesController@plans');
    Route::post('/pagar',    'Sales\SalesController@pay');
    Route::post('/pagar763',    'Sales\SalesController@payBoleto');

    Route::post('/status',   'Sales\SalesController@status');

});

