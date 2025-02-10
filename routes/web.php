<?php

use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\Auth\UserLogoutController;
use App\Http\Controllers\Dashboard\AppSettings\UpdateAppSettingsController;
use App\Http\Controllers\Dashboard\Post\ShowPostController as DashboardShowPostController;
use App\Http\Controllers\Dashboard\Post\ShowPostsController;
use App\Http\Controllers\Dashboard\User\CreateUserController;
use App\Http\Controllers\Dashboard\User\DeleteUserController;
use App\Http\Controllers\Dashboard\User\DestroyUserController;
use App\Http\Controllers\Dashboard\User\EditUserController;
use App\Http\Controllers\Dashboard\User\ShowUserController as DashboardShowUserController;
use App\Http\Controllers\Dashboard\User\ShowUsersController;
use App\Http\Controllers\Dashboard\User\UpdateUserController;
use App\Http\Controllers\Home\ShowHomeController;
use App\Http\Controllers\Post\Comment\AddCommentToPostController;
use App\Http\Controllers\Post\Comment\DeleteCommentController;
use App\Http\Controllers\Post\Comment\EditCommentController;
use App\Http\Controllers\Post\Comment\ShowPostCommentsController;
use App\Http\Controllers\Post\Comment\UpdateCommentController;
use App\Http\Controllers\Post\CreatePostController;
use App\Http\Controllers\Post\DeletePostController;
use App\Http\Controllers\Post\DestroyPostController;
use App\Http\Controllers\Post\EditPostController;
use App\Http\Controllers\Post\GetPostFormController;
use App\Http\Controllers\Post\ShowPostController;
use App\Http\Controllers\Post\UpdatePostController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\User\Settings\Avatar\CropAvatarController;
use App\Http\Controllers\User\Settings\Avatar\ResetAvatarController;
use App\Http\Controllers\User\Settings\Avatar\SetAvatarController;
use App\Http\Controllers\User\Settings\Details\SetDetailsController;
use App\Http\Controllers\User\Settings\Password\ChangeInitialPasswordController;
use App\Http\Controllers\User\Settings\Password\ChangePasswordController;
use App\Http\Controllers\User\Settings\Password\ForgotPasswordController;
use App\Http\Controllers\User\Settings\Password\ResetPasswordController;
use App\Http\Controllers\User\Settings\Password\ShowResetPasswordController;
use App\Http\Controllers\User\Settings\ShowAccountSettingsController;
use App\Http\Controllers\User\Settings\UpdateAuthenticatedUserController;
use App\Http\Controllers\User\ShowProfileController;
use App\Http\Controllers\User\WorkHistory\CreateWorkHistoryController;
use App\Http\Controllers\User\WorkHistory\DeleteWorkHistoryController;
use App\Http\Controllers\User\WorkHistory\DestroyWorkHistoryController;
use App\Http\Controllers\User\WorkHistory\EditWorkHistoryController;
use App\Http\Controllers\User\WorkHistory\PublishWorkHistoryController;
use App\Http\Controllers\User\WorkHistory\ShowAddWorkHistoryStepController;
use App\Http\Controllers\User\WorkHistory\ShowWorkHistoryController;
use App\Http\Controllers\User\WorkHistory\SkipAddingWorkHistoryController;
use App\Http\Controllers\User\WorkHistory\UpdateWorkHistoryController;
use App\Http\Middleware\AccountSetupCompleted;
use App\Http\Middleware\CanAccessSetupStep;
use Illuminate\Support\Facades\Route;

Route::as('auth.')->group(function () {
    Route::group(['prefix' => 'login', 'as' => 'login'], function () {
        Route::view('/', 'resources.auth.login');
        Route::post('/', UserLoginController::class);
    });

    Route::delete('/logout', UserLogoutController::class)->middleware('auth')->name('logout');

    Route::group(['prefix' => '/password', 'as' => 'password.'], function () {
        // Forgot password
        Route::group(['prefix' => '/forgot', 'as' => 'forgot'], function () {
            Route::view('/', 'resources.auth.forgot_password');
            Route::put('/', ForgotPasswordController::class)->name('.execute');
        });

        // Reset password
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
        // Change initial password
        Route::group(['prefix' => '/step/1', 'as' => 'step.1', 'middleware' => CanAccessSetupStep::class.':1'], function () {
            Route::view('/', 'resources.auth.setup.initial_password_change');
            Route::put('/', ChangeInitialPasswordController::class);
        });

        // Change user details
        Route::group(['prefix' => '/step/2', 'as' => 'step.2', 'middleware' => CanAccessSetupStep::class.':2'], function () {
            Route::view('/', 'resources.auth.setup.add_details');
            Route::put('/', SetDetailsController::class);
        });

        // Add previous work
        Route::group(['prefix' => '/step/3', 'as' => 'step.3', 'middleware' => CanAccessSetupStep::class.':3'], function () {
            Route::get('/', ShowAddWorkHistoryStepController::class);
            Route::patch('/skip', SkipAddingWorkHistoryController::class)->name('.skip');
        });
    });
});

Route::group(['prefix' => 'users', 'as' => 'users', 'middleware' => ['auth', AccountSetupCompleted::class]], function () {
    Route::get('/profile/{user}', ShowProfileController::class)
        ->name('.profile');

    Route::group(['prefix' => 'settings', 'as' => '.settings'], function () {
        Route::get('/', ShowAccountSettingsController::class);
        Route::put('/update', UpdateAuthenticatedUserController::class)->name('.update');
        Route::patch('/password', ChangePasswordController::class)->name('.changePassword');
        // Avatar settings
        Route::post('/avatar/crop', CropAvatarController::class)->name('.avatarCrop');
        Route::post('/avatar', SetAvatarController::class)->name('.avatar');
        Route::patch('/avatar/reset', ResetAvatarController::class)->name('.avatarReset');
    });

});

Route::group(['prefix' => 'workHistory', 'as' => 'workHistory'], function () {
    Route::get('/show', ShowWorkHistoryController::class)->name('.show');

    // Create work history
    Route::group(['prefix' => 'create', 'as' => '.create'], function () {
        Route::view('/', 'resources.user.workHistory.create');
        Route::post('/', CreateWorkHistoryController::class);
    });

    // Publish work history
    Route::put('/publish', PublishWorkHistoryController::class)->name('.publish');

    // Edit work history
    Route::group(['prefix' => 'edit', 'as' => '.edit'], function () {
        Route::get('/{workHistory}', EditWorkHistoryController::class);
        Route::patch('/{workHistory}', UpdateWorkHistoryController::class);
    });

    // Delete work history
    Route::group(['prefix' => 'delete', 'as' => '.delete'], function () {
        Route::get('/{workHistory}', DeleteWorkHistoryController::class);
        Route::delete('/{workHistory}', DestroyWorkHistoryController::class);
    });
});

Route::group(['prefix' => 'posts', 'as' => 'post', 'middleware' => 'auth'], function () {
    Route::get('/{post}', ShowPostController::class)->name('.show');

    Route::group(['prefix' => '/create', 'as' => '.create'], function () {
        Route::view('/', 'posts/create');
        Route::get('/form/{type}', GetPostFormController::class)->name('.form');
        Route::post('/{type}', CreatePostController::class)->name('.execute');
    });

    Route::group(['prefix' => 'edit', 'as' => '.edit'], function () {
        Route::get('/{post}', EditPostController::class);
        Route::put('/{post}', UpdatePostController::class);
    });

    Route::group(['prefix' => 'delete', 'as' => '.delete'], function () {
        Route::get('/{post}', DeletePostController::class);
        Route::delete('/{post}', DestroyPostController::class);
    });

    Route::group(['prefix' => 'comments', 'as' => '.comment'], function () {
        // Show posts comments
        Route::get('/{post}', ShowPostCommentsController::class);

        // Create comment
        Route::post('/{post}', AddCommentToPostController::class)->name('.create');

        // Edit comment
        Route::group(['prefix' => 'edit', 'as' => '.edit'], function () {
            Route::get('/{comment}', EditCommentController::class);
            Route::put('/{comment}', UpdateCommentController::class);
        });

        // Delete comment
        Route::group(['prefix' => 'delete', 'as' => '.delete'], function () {
            Route::view('/{comment}', 'resources.post.comments.delete');
            Route::delete('/{comment}', DeleteCommentController::class);
        });
    });
});

// Admin Dashboard
Route::group(['prefix' => 'admin', 'as' => 'admin', 'middleware' => ['auth', 'role:admin']], function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::view('/dashboard', 'resources.dashboard.dashboard')->name('.dashboard');

    Route::group(['prefix' => 'users', 'as' => '.users'], function () {
        // Show all users
        Route::get('/', ShowUsersController::class);

        // Show user
        Route::get('/show/{user}', DashboardShowUserController::class)->name('.show');

        // Create user
        Route::group(['prefix' => 'create', 'as' => '.create'], function () {
            Route::view('/', 'resources.dashboard.users.create');
            Route::post('/', CreateUserController::class);
        });

        // Edit user
        Route::group(['prefix' => 'edit', 'as' => '.edit'], function () {
            Route::get('/{user}', EditUserController::class);
            Route::put('/{user}', UpdateUserController::class);
        });

        // Delete user
        Route::group(['prefix' => 'delete', 'as' => '.delete'], function () {
            Route::get('/{user}', DeleteUserController::class);
            Route::delete('/{user}', DestroyUserController::class);
        });
    });

    Route::group(['prefix' => 'posts', 'as' => '.posts'], function () {
        Route::get('/', ShowPostsController::class);
        Route::get('/{post}', DashboardShowPostController::class)->name('.show');
    });

    Route::group(['prefix' => 'settings', 'as' => '.settings'], function () {
        Route::view('/', 'resources.dashboard.settings');
        Route::put('/', UpdateAppSettingsController::class);
    });
});

Route::get('/home', ShowHomeController::class)
    ->middleware(['auth', AccountSetupCompleted::class])
    ->name('home');

Route::get('/redirect', RedirectController::class)->name('redirect');
