<?php

namespace App\Console\Commands\User;

use App\Console\Commands\Traits\HasValidator;
use App\Enums\UserRoles;
use App\Models\User;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Repositories\Contracts\MerchantRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\password;
use function Laravel\Prompts\select;
use function Laravel\Prompts\table;
use function Laravel\Prompts\text;

class CreateUserCommand extends Command
{
    use HasValidator;

    public function __construct(protected MerchantRepositoryInterface $merchantRepository, protected AccountRepositoryInterface $accountRepository)
    {
        parent::__construct();
    }
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create user using terminal command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data['role'] = select(
            label: 'Select user role',
            options: UserRoles::array()
        );

        if ($data['role'] === UserRoles::MERCHANT->value) {
            $merchantUuid = text(
                label: 'Merchant UUID: ',
                required: true,
                validate: fn (string $value) => $this->validate($value, 'merchant_uuid', ['string', 'exists:merchants,uuid'])
            );

            $merchant = $this->merchantRepository->findByUuid($merchantUuid);

            $data['merchant_id'] = $merchant->id;
        }

        $data['name'] = text(
            label: 'Name: ',
            required: true,
            validate: fn (string $value) => $this->validate($value, 'name', ['string', 'max:255'])
        );

        $data['email'] = text(
            label: 'Email: ',
            required: true,
            validate: fn (string $value) => $this->validate($value, 'email', ['email', 'unique:users,email'])
        );

        $passwordRules = Password::min(8);
        $hint = "Minimum of 8 characters.\n";

        $rawPassword = password(
            label: 'Password: ',
            validate: fn (string $value) => $this->validate($value, 'password', [$passwordRules]),
            hint: $hint
        );

        if(trim($rawPassword) == ''){
            $rawPassword = Str::password(8);
        }

        // hash password
        $data['password'] = Hash::make($rawPassword);

        $verifyEmail = confirm('Auto verify email?', default: false);
        if($verifyEmail){
            $data['email_verified_at'] = now();
        }

        $confirmed = confirm(
            label: 'Do you wish to continue with the above data?',
            default: false,
            yes: 'Continue',
            no: 'Cancel',
        );

        if($confirmed){
            try {
                DB::beginTransaction();

                if (empty($data['merchant_id'])) {
                    $user = User::create($data);
                }
                else {
                    $user = $this->accountRepository->create($data);
                }

                table(
                    ['ID', 'Name', 'Email', 'Password', 'Role'],
                    [[$user->uuid, $user->name, $user->email, $rawPassword, Str::of($user->role->value)->headline()]]
                );

                DB::commit();

                info('User creation confirmed.');
            } catch (\Exception $e) {
                DB::rollBack();
                report($e);
                error('Unable to create user. Error: ' . $e->getMessage() . ' at line ' . $e->getLine());
                return self::FAILURE;
            }
            
        } else{
            info('User creation cancelled.');
        }

        if(in_array($data['role'], [UserRoles::ADMIN, UserRoles::MERCHANT])) {
            $token = $user->createToken($user->name);
            $platformToken = explode('|', $token->plainTextToken, 2)[1];
            info("Access Token: {$platformToken}");
            info("Plain Token: {$token->plainTextToken}");
        }
        return self::SUCCESS;
    }
}
