namespace App\Providers;

use Illuminate\Auth\SessionGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Auth::extend('status-check', function ($app, $name, array $config) {
            $guard = new class($name, $app['auth']->createUserProvider($config['provider']), $app['session.store'], $app['request']) extends SessionGuard {
                public function attempt(array $credentials = [], $remember = false)
                {
                    $user = $this->provider->retrieveByCredentials($credentials);

                    if ($user && $user->status === 'Active' && $this->provider->validateCredentials($user, $credentials)) {
                        $this->login($user, $remember);
                        return true;
                    }

                    return false;
                }
            };

            return $guard;
        });
    }
}