<?php

use App\Http\Actions\Auth\UserLogout;
use App\Http\Actions\Profile\ShowProfileController;
use App\Http\Controllers\Auth\ChangeInitialPasswordController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\CropAvatarController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetAvatarController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SetAvatarController;
use App\Http\Controllers\Auth\SetDetailsController;
use App\Http\Controllers\Auth\ShowAccountSettingsController;
use App\Http\Controllers\Auth\ShowAddWorkHistoryStepController;
use App\Http\Controllers\Auth\ShowResetPasswordController;
use App\Http\Controllers\Auth\UpdateUserController;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\Dashboard\AppSettings\UpdateAppSettingsController;
use App\Http\Controllers\Dashboard\CreateUserController;
use App\Http\Controllers\Dashboard\EditUserController;
use App\Http\Controllers\Dashboard\Post\ShowPostController;
use App\Http\Controllers\Dashboard\Post\ShowPostsController;
use App\Http\Controllers\Dashboard\ShowUsersController;
use App\Http\Controllers\Dashboard\UpdateUserController as DashboardUpdateUserController;
use App\Http\Controllers\Dashboard\User\DeleteUserController;
use App\Http\Controllers\Dashboard\User\DestroyUserController;
use App\Http\Controllers\Dashboard\User\ShowUserController as DashboardShowUserController;
use App\Http\Controllers\Home\ShowHomeController;
use App\Http\Controllers\Post\Comment\AddCommentToPostController;
use App\Http\Controllers\Post\Comment\DeleteCommentController;
use App\Http\Controllers\Post\Comment\EditCommentController;
use App\Http\Controllers\Post\Comment\ShowPostCommentsController;
use App\Http\Controllers\Post\Comment\UpdateCommentController;
use App\Http\Controllers\Post\CreatePostController;
use App\Http\Controllers\Post\GetPostFormController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\WorkHistory\CreateWorkHistoryController;
use App\Http\Controllers\WorkHistory\DeleteWorkHistoryController;
use App\Http\Controllers\WorkHistory\DestroyWorkHistoryController;
use App\Http\Controllers\WorkHistory\EditWorkHistoryController;
use App\Http\Controllers\WorkHistory\PublishWorkHistoryController;
use App\Http\Controllers\WorkHistory\ShowWorkHistoryController;
use App\Http\Controllers\WorkHistory\SkipAddingWorkHistoryController;
use App\Http\Controllers\WorkHistory\UpdateWorkHistoryController;
use App\Http\Middleware\AccountSetupCompleted;
use App\Http\Middleware\CanAccessSetupStep;
use Illuminate\Support\Facades\Route;

Route::as('auth.')->group(function () {
    Route::group(['prefix' => 'login', 'as' => 'login'], function () {
        Route::view('/', 'resources.auth.login');
        Route::post('/', UserLoginController::class)->name('.execute');
    });

    Route::delete('/logout', UserLogout::class)->middleware('auth')->name('logout');

    Route::group(['prefix' => '/password', 'as' => 'password.'], function () {
        Route::group(['prefix' => '/forgot', 'as' => 'forgot'], function () {
            Route::view('/', 'resources.auth.forgot_password');
            Route::put('/', ForgotPasswordController::class)->name('.execute');
        });

        Route::group(['prefix' => '/reset', 'as' => 'reset'], function () {
            Route::get('/{token}', ShowResetPasswordController::class);
            Route::put('/{token}', ResetPasswordController::class)->name('.execute');
        });
    });

    Route::group([
        'prefix' => '/setup',
        'as' => 'setup.',
        'middleware' => 'auth',
    ], function () {
        Route::group(['prefix' => '/step/1', 'as' => 'step.1', 'middleware' => CanAccessSetupStep::class.':1'], function () {
            Route::view('/', 'resources.auth.setup.initial_password_change');
            Route::put('/', ChangeInitialPasswordController::class);
        });

        Route::group(['prefix' => '/step/2', 'as' => 'step.2', 'middleware' => CanAccessSetupStep::class.':2'], function () {
            Route::view('/', 'resources.auth.setup.add_details');
            Route::put('/', SetDetailsController::class);
        });

        Route::group(['prefix' => '/step/3', 'as' => 'step.3', 'middleware' => CanAccessSetupStep::class.':3'], function () {
            Route::get('/', ShowAddWorkHistoryStepController::class);
            Route::patch('/skip', SkipAddingWorkHistoryController::class)->name('.skip');
        });
    });

    Route::group(['prefix' => 'settings', 'as' => 'settings', 'middleware' => 'auth'], function () {
        Route::get('/', ShowAccountSettingsController::class);
        Route::put('/update', UpdateUserController::class)->name('.update');
        Route::post('/avatar/crop', CropAvatarController::class)->name('.avatarCrop');
        Route::post('/avatar', SetAvatarController::class)->name('.avatar');
        Route::patch('/avatar/reset', ResetAvatarController::class)->name('.avatarReset');
        Route::patch('/password', ChangePasswordController::class)->name('.changePassword');
    });
});

Route::group(['prefix' => 'workHistory', 'as' => 'workHistory'], function () {
    Route::get('/show', ShowWorkHistoryController::class)->name('.show');

    Route::group(['prefix' => 'create', 'as' => '.create'], function () {
        Route::view('/', 'resources.user.workHistory.create');
        Route::post('/', CreateWorkHistoryController::class);
    });

    Route::put('/publish', PublishWorkHistoryController::class)->name('.publish');

    Route::group(['prefix' => 'edit', 'as' => '.edit'], function () {
        Route::get('/{workHistory}', EditWorkHistoryController::class);
        Route::patch('/{workHistory}', UpdateWorkHistoryController::class);
    });

    Route::group(['prefix' => 'delete', 'as' => '.delete'], function () {
        Route::get('/{workHistory}', DeleteWorkHistoryController::class);
        Route::delete('/{workHistory}', DestroyWorkHistoryController::class);
    });
});

Route::group(['prefix' => 'posts', 'as' => 'post', 'middleware' => 'auth'], function () {
    Route::group(['prefix' => '/create', 'as' => '.create'], function () {
        Route::view('/', 'posts/create');
        Route::get('/form/{type}', GetPostFormController::class)->name('.form');
        Route::post('/{type}', CreatePostController::class)->name('.execute');
    });

    Route::group(['prefix' => 'comments', 'as' => '.comment'], function () {
        Route::get('/{post}', ShowPostCommentsController::class);
        Route::post('/{post}', AddCommentToPostController::class)->name('.create');

        Route::group(['prefix' => 'edit', 'as' => '.edit'], function () {
            Route::get('/{comment}', EditCommentController::class);
            Route::put('/{comment}', UpdateCommentController::class);
        });

        Route::group(['prefix' => 'delete', 'as' => '.delete'], function () {
            Route::view('/{comment}', 'resources.post.comments.delete');
            Route::delete('/{comment}', DeleteCommentController::class);
        });
    });
});

Route::group(['prefix' => 'admin', 'as' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::view('/dashboard', 'resources.dashboard.dashboard')->name('.dashboard');

    Route::group(['prefix' => 'users', 'as' => '.users'], function () {
        // Show all users
        Route::get('/', ShowUsersController::class);

        // View user
        Route::get('/{user}', DashboardShowUserController::class)->name('.show');

        // Create user
        Route::group(['prefix' => 'create', 'as' => '.create'], function () {
            Route::view('/', 'resources.dashboard.users.create');
            Route::post('/', CreateUserController::class);
        });

        // Edit user
        Route::group(['prefix' => 'edit', 'as' => '.edit'], function () {
            Route::get('/{user}', EditUserController::class);
            Route::put('/{user}', DashboardUpdateUserController::class);
        });

        // Delete user
        Route::group(['prefix' => 'delete', 'as' => '.delete'], function () {
            Route::get('/{user}', DeleteUserController::class);
            Route::delete('/{user}', DestroyUserController::class);
        });
    });

    Route::group(['prefix' => 'posts', 'as' => '.posts'], function () {
        Route::get('/', ShowPostsController::class);
        Route::get('/{post}', ShowPostController::class)->name('.show');
    });

    Route::group(['prefix' => 'settings', 'as' => '.settings'], function () {
        Route::view('/', 'resources.dashboard.settings');
        Route::put('/', UpdateAppSettingsController::class);
    });
});

Route::get('/profile/{user}', ShowProfileController::class)
    ->middleware(['auth', AccountSetupCompleted::class])
    ->name('profile');

Route::get('/home', ShowHomeController::class)
    ->middleware(['auth', AccountSetupCompleted::class])
    ->name('home');

Route::get('/redirect', RedirectController::class)->name('redirect');
