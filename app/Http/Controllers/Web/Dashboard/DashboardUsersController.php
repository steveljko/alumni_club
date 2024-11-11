<?php

namespace App\Http\Controllers\Web\Dashboard;

use Validator;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Utils\FormBuilder\Option;
use App\Utils\FormBuilder\FormBuilder;

class DashboardUsersController
{
    public function __invoke(Request $request): View
    {
        $updateForm = $this->getUpdateForm();

        $users = User::with('details');

        if ($request->query('name')) {
            $users->where('name', 'LIKE', '%'.$request->name.'%');
        }

        if ($request->query('uni_start_year')) {
            $users->whereHas('details', function ($query) use ($request) {
                return $query->where('uni_start_year', $request->uni_start_year);
            });
        }

        $users = $users->paginate(10)->appends(request()->query());

        return view('dashboard/users', compact('users', 'updateForm'));
    }

    public function updateUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::find($request->id);
        $user->update($request->all());

        return response()->json($user, 200);
    }

    protected function getUpdateForm(): string
    {
        return (new FormBuilder(
            name: 'updateUser',
            method: 'POST',
            route: route('web.dashboard.updateUser'),
        ))
            ->addField(name: 'id', options: [
                'placeholder' => 'id',
            ])
            ->addField(name: 'name', options: [
                'label' => 'Ime i Prezime',
                'placeholder' => 'Unesite ime i prezime',
            ])
            ->addField(name: 'email', options: [
                'inputType' => 'email',
                'label' => 'Email adresa',
                'placeholder' => 'Unesite email adresu',
            ])
            ->addField(name: 'role', type: 'select', options: [
                'label' => 'Odaberite ulogu',
                'options' => Option::fromEnum(UserRole::class),
            ])
            ->addField(name: 'uni_start_year', type: 'select', options: [
                'label' => 'Odaberite godinu upisa faksa',
                'options' => array_map(function ($year) {
                    return new Option(value: (string) $year, name: (string) $year);
                }, range(1910, date('Y'))),
            ])
            ->addField(name: 'uni_finish_year', type: 'select', options: [
                'label' => 'Odaberite godinu završetka faksa',
                'options' => array_map(function ($year) {
                    return new Option(value: (string) $year, name: (string) $year);
                }, range(1910, date('Y'))),
            ])
            ->withButtonText(text: 'Izmeni korisnika')
            ->render();
    }
}
