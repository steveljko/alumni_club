<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Models\User;
use App\Enums\UserRole;
use App\Utils\TableBuilder;
use Illuminate\Http\Request;
use App\Utils\FormBuilder\Option;
use App\Utils\FormBuilder\FormBuilder;
use App\Utils\FormBuilder\Fields\Input;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\PaginateResource;
use App\Utils\FormBuilder\Fields\Select;
use App\Http\Resources\User\UserResource;
use App\Utils\FormBuilder\Fields\Primary;
use App\Traits\Concerns\Enums\FilterOperators;

class DashboardUsersController
{
    public function __invoke(Request $request)
    {
        if ($request->ajax()) {
            return $this->getTable(pagination: false);
        }

        return view('dashboard/users', [
            'users' => $this->getUsers(),
            'searchForm' => $this->getSearchForm(),
            'updateForm' => $this->getUpdateForm(),
            'usersTable' => $this->getTable(),
        ]);
    }

    public function updateUser(UpdateUserRequest $request): string
    {
        $user = User::find($request->id);

        $user->update($request->only(['name']));
        $user->details->update($request->only(['uni_start_year', 'uni_finish_year']));

        return $this->getTable(pagination: false);
    }

    protected function getSearchForm(): string
    {
        return FormBuilder::build(
            name: 'searchForm',
            fields: [
                new Input(name: 'name[lk]', label: 'Ime i Prezime', placeholder: 'Unesite Ime i Prezime', inputType: 'text'),
                new Select(name: 'details_uni_start_year[gte]', label: 'Odaberite godinu upisa faksa', placeholder: 'Godina upisa', options: Option::fromYearRange(from: 2000)),
                new Select(name: 'details_uni_finish_year[lte]', label: 'Odaberite godinu zavšetka faksa', placeholder: 'Godina završetka', options: Option::fromYearRange(from: 2000)),
            ],
            btnText: 'Pretraži'
        );
    }

    protected function getUpdateForm(): string
    {
        return FormBuilder::build(
            name: 'updateUser',
            method: Request::METHOD_POST,
            route: route('web.dashboard.updateUser'),
            fields: [
                new Primary(name: 'id'),
                new Input(name: 'name', label: 'Ime i Prezime', placeholder: 'Unesite ime i prezime', inputType: 'text'),
                new Input(name: 'email', label: 'Email adresa', placeholder: 'Unesite email adresu', inputType: 'email'),
                new Select(name: 'role', label: 'Odaberite ulogu', placeholder: 'Uloga', options: Option::fromEnum(UserRole::class)),
                new Select(name: 'uni_start_year', label: 'Odaberite godinu upisa faksa', placeholder: 'Upis faks', options: Option::fromYearRange(from: 2000)),
                new Select(name: 'uni_finish_year', label: 'Odaberite godinu završetka faksa', placeholder: 'Završetak faks', options: Option::fromYearRange(from: 2000)),
            ],
            btnText: 'Izmeni'
        );
    }

    protected function getUsers(): PaginateResource
    {
        $users = User::filterWithPagination(
            allowedParams: [
                'name' => [FilterOperators::LIKE],
                'details' => [
                    'uni_start_year' => [FilterOperators::GREATER_THAN_EQUALS],
                    'uni_finish_year' => [FilterOperators::LESS_THAN_EQUALS],
                ],
            ],
            with: ['details'],
            resource: UserResource::class,
        );

        return $users->getData();
    }

    protected function getTable(bool $pagination = true): string
    {
        return TableBuilder::build(
            name: 'users',
            columns: [
                ['header' => 'Ime i prezime', 'field' => 'name'],
                ['header' => 'Godina upisa', 'field' => 'details.uni_start_year'],
            ],
            data: $this->getUsers(),
            pagination: $pagination,
        );
    }
}
