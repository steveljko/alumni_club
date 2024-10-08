<?php

return [
    'model_not_found' => ':model with :id is not found.',
    'initial_password_must_be_changed' => 'You must first change the initial password to be able to use the application.',

    'pagination' => [
        'invalid_page_number' => 'Page with this number is invalid.',
        'page_not_found' => 'Page is not found.',
    ],

    'users' => [
        'details_successful_update' => 'User details successfully updated.',
        'details_failed_update' => 'User details update failed! Please, try again.',

        'find_success' => '{1} :count user found.|[2,*] :count user\'s found.',
        'find_fail' => 'No users found with these search criteria.',

        'get' => 'User found.',
    ],

    'jobs' => [
        'unauthorized' => 'You don\'t have permission to do this operation on this job.',

        'successful_create' => 'Job successfully created.',
        'successful_update' => 'Job successfully updated.',
        'successful_delete' => 'Job succesfully deleted.',

        'failed_update' => 'Job update failed! Please, try again.',
        'failed_delete' => 'Job delete failed!',
    ],

    'posts' => [
        'unauthorized' => 'You don\'t have permission to do this operation on this post.',

        'successful_create' => 'Post successfully created.',
        'successful_update' => 'Post successfully updated.',
        'successful_delete' => 'Post succesfully deleted.',

        'failed_update' => 'Post update failed! Please, try again.',
        'failed_delete' => 'Job update failed! Please, try again.',
    ],
];
