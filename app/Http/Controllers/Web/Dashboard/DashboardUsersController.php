<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Utils\FormBuilder\Option;
use App\Utils\FormBuilder\FormBuilder;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Traits\Concerns\Enums\FilterOperators;

class DashboardUsersController
{
    public function __invoke(Request $request): View
    {
        return view('dashboard/users', [
            'users' => $this->getUsers(request: $request),
            'searchForm' => $this->getSearchForm(),
            'updateForm' => $this->getUpdateForm(),
        ]);
    }

    public function updateUser(UpdateUserRequest $request)
    {
        $user = User::find($request->id);

        $user->update($request->only(['name']));
        $user->details->update($request->only(['uni_start_year', 'uni_finish_year']));

        return view('markup/users_table')->with('users', $this->getUsers($request));
    }

    public function searchUser(Request $request)
    {
        return view('markup/users_table')->with('users', $this->getUsers($request));
    }

    protected function getSearchForm(): string
    {
        return FormBuilder::build(
            name: 'searchForm',
            method: Request::METHOD_GET,
            route: route('web.dashboard.searchUser'),
            fields: [
                'name[lk]' => [
                    'label' => 'Ime i Prezime',
                    'placeholder' => 'Unesite ime i prezime',
                ],
                'details_uni_start_year[eq]' => [
                    'label' => 'Odaberite godinu upisa faksa',
                    'type' => 'select',
                    'options' => Option::fromYearRange(from: 2000),
                ],
            ],
            btnText: 'Pretraži');
    }

    protected function getUpdateForm(): string
    {
        return FormBuilder::build(
            name: 'updateUser',
            method: Request::METHOD_POST,
            route: route('web.dashboard.updateUser'),
            fields: [
                'id' => ['placeholder' => 'id'],
                'name' => [
                    'label' => 'Ime i Prezime',
                    'placeholder' => 'Unesite ime i prezime',
                ],
                'email' => [
                    'inputType' => 'email',
                    'label' => 'Email adresa',
                    'placeholder' => 'Unesite email adresu',
                ],
                'role' => [
                    'label' => 'Odaberite ulogu',
                    'type' => 'select',
                    'options' => Option::fromEnum(UserRole::class),
                ],
                'uni_start_year' => [
                    'label' => 'Odaberite godinu upisa faksa',
                    'type' => 'select',
                    'options' => Option::fromYearRange(from: 2000),
                ],
                'uni_finish_year' => [
                    'label' => 'Odaberite godinu završetka faksa',
                    'type' => 'select',
                    'options' => Option::fromYearRange(from: 2000),
                ],
            ],
            btnText: 'Izmeni');
    }

    protected function getUsers(Request $request)
    {
        $users = User::filterWithPagination(
            allowedParams: [
                'name' => [FilterOperators::LIKE],
                'details' => [
                    'uni_start_year' => [FilterOperators::EQUALS],
                    'uni_finish_year' => [FilterOperators::EQUALS],
                ],
            ],
            with: ['details'],
            resource: UserResource::class,
        );

        return $users->getData();
    }
}
