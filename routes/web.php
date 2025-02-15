<?php

use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\Auth\UserLogoutController;
use App\Http\Controllers\Dashboard\AppSettings\UpdateAppSettingsController;
use App\Http\Controllers\Dashboard\Post\ShowPostController as DashboardShowPostController;
use App\Http\Controllers\Dashboard\Post\ShowPostsController;
use App\Http\Controllers\Dashboard\ShowActivityController;
use App\Http\Controllers\Dashboard\ShowDashboardController;
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
use App\Http\Controllers\Post\Like\DislikePostController;
use App\Http\Controllers\Post\Like\LikePostController;
use App\Http\Controllers\Post\ShowPostController;
use App\Http\Controllers\Post\ShowUserPostsController;
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
use App\Http\Controllers\User\WorkHistory\ShowUsersWorkHistoryController;
use App\Http\Controllers\User\WorkHistory\ShowWorkHistoryController;
use App\Http\Controllers\User\WorkHistory\SkipAddingWorkHistoryController;
use App\Http\Controllers\User\WorkHistory\UpdateWorkHistoryController;
use App\Http\Middleware\AccountSetupCompleted;
use App\Http\Middleware\CanAccessSetupStep;
use App\Http\Middleware\MaintenanceMode;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('home');
});

Route::as('auth.')->group(function () {
    Route::group(['prefix' => 'login', 'as' => 'login'], function () {
        Route::view('/', 'resources.auth.login');
        Route::post('/', UserLoginController::class);
    });

    Route::delete('/logout', UserLogoutController::class)->middleware('auth')->name('logout');

    Route::group(['prefix' => 'password', 'as' => 'password.'], function () {
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
        Route::group(['prefix' => 'step/1', 'as' => 'step.1', 'middleware' => CanAccessSetupStep::class.':1'], function () {
            Route::view('/', 'resources.auth.setup.initial_password_change');
            Route::put('/', ChangeInitialPasswordController::class);
        });

        // Add more details
        Route::group(['prefix' => 'step/2', 'as' => 'step.2', 'middleware' => CanAccessSetupStep::class.':2'], function () {
            Route::view('/', 'resources.auth.setup.add_details');
            Route::put('/', SetDetailsController::class);
        });

        // Add previous work history
        Route::group(['prefix' => 'step/3', 'as' => 'step.3', 'middleware' => CanAccessSetupStep::class.':3'], function () {
            Route::get('/', ShowAddWorkHistoryStepController::class);
            Route::view('/skip', 'resources.auth.setup.skip_adding_work_history')->name('.skip');
            Route::patch('/skip', SkipAddingWorkHistoryController::class)->name('.skip');
        });
    });
});

Route::group([
    'prefix' => 'users',
    'as' => 'users',
    'middleware' => ['auth', AccountSetupCompleted::class],
], function () {
    // User profile
    Route::get('/profile/{user}', ShowProfileController::class)->name('.profile');
    Route::get('/profile/{user}/posts', ShowUserPostsController::class)->name('.profile.posts');
    Route::get('/profile/{user}/workHistory', ShowUsersWorkHistoryController::class)->name('.profile.workHistories');

    // User settings
    Route::group(['prefix' => 'settings', 'as' => '.settings'], function () {
        Route::get('/', ShowAccountSettingsController::class);
        Route::put('/update', UpdateAuthenticatedUserController::class)->name('.update');
        Route::patch('/password', ChangePasswordController::class)->name('.changePassword');
        // Avatar settings
        Route::post('/avatar/crop', CropAvatarController::class)->name('.avatarCrop');
        Route::post('/avatar', SetAvatarController::class)->name('.avatar');
        Route::patch('/avatar/reset', ResetAvatarController::class)->name('.avatarReset');
    });

    // User work histories
    Route::group([
        'prefix' => 'workHistories',
        'as' => '.workHistories',
        'excluded_middleware' => [AccountSetupCompleted::class], // excluded for step 3 in wizard
    ], function () {
        // Create work history
        Route::view('/create', 'resources.user.workHistory.create')->name('.create');
        Route::post('/', CreateWorkHistoryController::class)->name('.store');

        // Read work history
        Route::get('/', ShowWorkHistoryController::class);
        Route::get('/{user}', ShowUsersWorkHistoryController::class)->name('.show');

        // Update work history
        Route::get('/{workHistory}/edit', EditWorkHistoryController::class)->name('.edit');
        Route::patch('/{workHistory}', UpdateWorkHistoryController::class)->name('.update');
        Route::put('/publish', PublishWorkHistoryController::class)->name('.publish');

        // Delete work history
        Route::get('/{workHistory}/delete', DeleteWorkHistoryController::class)->name('.delete');
        Route::delete('/{workHistory}', DestroyWorkHistoryController::class)->name('.destroy');
    });
});

Route::group(['prefix' => 'posts', 'as' => 'posts', 'middleware' => 'auth'], function () {
    // Create post
    Route::view('/', 'posts.create')->name('.create');
    Route::get('/{type}/form', GetPostFormController::class)->name('.getForm');
    Route::post('/{type}', CreatePostController::class)->name('.store');

    // Read post
    Route::get('/{post}', ShowPostController::class)->name('.show');

    // Update post
    Route::get('/{post}/edit', EditPostController::class)->name('.edit');
    Route::put('/{post}', UpdatePostController::class)->name('.update');
    Route::patch('/{post}/like', LikePostController::class)->name('.like');
    Route::patch('/{post}/dislike', DislikePostController::class)->name('.dislike');

    // Delete post
    Route::get('/{post}/delete', DeletePostController::class)->name('.delete');
    Route::delete('/{post}', DestroyPostController::class)->name('.destroy');

    // Post comments
    Route::group(['prefix' => 'comments', 'as' => '.comments'], function () {
        // Show post comments
        Route::get('/{post}', ShowPostCommentsController::class);

        // Create post comment
        Route::post('/{post}', AddCommentToPostController::class)->name('.create');

        // Update post comment
        Route::get('/{comment}/edit', EditCommentController::class)->name('.edit');
        Route::put('/{comment}', UpdateCommentController::class)->name('.update');

        // Delete post comment
        Route::view('/{comment}/delete', 'resources.post.comments.delete')->name('.delete');
        Route::delete('/{comment}', DeleteCommentController::class)->name('.destroy');
    });
});

// Admin Dashboard
Route::group(['prefix' => 'admin', 'as' => 'admin', 'middleware' => ['auth', 'role:admin']], function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::group(['prefix' => 'dashboard', 'as' => '.dashboard'], function () {
        Route::get('/', ShowDashboardController::class);
        Route::get('/activity/{activity}', ShowActivityController::class)->name('.activity.show');
    });

    Route::group(['prefix' => 'users', 'as' => '.users'], function () {
        // Create user
        Route::view('/create', 'resources.dashboard.users.create')->name('.create');
        Route::post('/', CreateUserController::class)->name('.store');

        // Read users
        Route::get('/', ShowUsersController::class);
        Route::get('/{user}', DashboardShowUserController::class)->name('.show');

        // Update user
        Route::get('/{user}/edit', EditUserController::class)->name('.edit');
        Route::put('/{user}', UpdateUserController::class)->name('.update');

        // Delete user
        Route::get('/{user}/delete', DeleteUserController::class)->name('.delete');
        Route::delete('/{user}', DestroyUserController::class)->name('.destroy');
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
    ->middleware(['auth', AccountSetupCompleted::class, MaintenanceMode::class])
    ->name('home');

Route::get('/maintenance', function () {
    return view('resources.maintenance');
})->name('maintenance');

Route::get('/redirect', RedirectController::class)->name('redirect');
