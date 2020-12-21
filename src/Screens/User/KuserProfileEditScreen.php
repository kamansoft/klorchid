<?php

declare(strict_types=1);

namespace Kamansoft\Klorchid\Screens\User;

use App\Orchid\Layouts\User\UserEditLayout;
use Kamansoft\Klorchid\Layouts\User\KuserEditLayout;
use Kamansoft\Klorchid\Layouts\User\KuserProfileEditLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Kamansoft\Klorchid\Models\Kuser;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Password;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Fields\Cropper;

class KuserProfileEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Profile';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Basic information';

    /**
     * @var User
     */
    protected $user;

    /**
     * Query data.
     *
     * @param Request $request
     *
     * @return array
     */
    public function query(Request $request): array
    {
        $user  = $request->user();
        \Debugbar::info(get_class($user));
        \Debugbar::info('type ');

        if (get_class($user)!==Kuser::class){
            throw new \Exception('Klorchid pakcage needs the user model to be setted widely on your laravel, ');
        }



        $this->user = $request->user();


        return [
            'user' => $this->user,
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [
            DropDown::make(__('Settings'))
                ->icon('open')
                ->list([
                    ModalToggle::make(__('Change Password'))
                        ->icon('lock-open')
                        ->method('changePassword')
                        ->modal('password'),
                ]),

            Button::make(__('Save'))
                ->icon('check')
                ->method('save'),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                Cropper::make('user.kavatar')
                    ->title(__('Profile Picture'))
                    ->targetId()

                    ->width(500)
                    ->height(500),


            ]),
            UserEditLayout::class,

            Layout::modal('password', [
                Layout::rows([
                    Password::make('old_password')
                        ->placeholder(__('Enter the current password'))
                        ->required()
                        ->title(__('Old password'))
                        ->help('This is your password set at the moment.'),

                    Password::make('password')
                        ->placeholder(__('Enter the password to be set'))
                        ->required()
                        ->title(__('New password')),

                    Password::make('password_confirmation')
                        ->placeholder(__('Enter the password to be set'))
                        ->required()
                        ->title(__('Confirm new password'))
                        ->help('A good password is at least 15 characters or at least 8 characters long, including a number and a lowercase letter.'),
                ]),
            ])
                ->title(__('Change Password'))
                ->applyButton('Update password'),
        ];
    }

    /**
     * @param Request $request
     */
    public function save(Request $request)
    {


        $request->validate([
            //'user.kavatar'=>'integer',
            'user.name' => 'required|string',
            'user.email' => [
                'required',
                Rule::unique(Kuser::class, 'email')->ignore($request->user()),
            ],
        ]);



        \Debugbar::info($request->user());
        \Debugbar::info('user on request');


        $request->user()
            ->fill($request->get('user'))
            ->save();



    }

    /**
     * @param Request $request
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|password:web',
            'password' => 'required|confirmed',
        ]);

        tap($request->user(), function ($user) use ($request) {
            $user->password = Hash::make($request->get('password'));
        })->save();

        Toast::info(__('Password changed.'));
    }
}
