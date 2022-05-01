@extends("mainSite.index")	 
@section("content")
       <!-- Validation Errors -->
        <x-auth-validation-errors class="validation_errors" :errors="$errors" />
        <table class="formTable">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <tr>
                    <td><x-label for="email" :value="__('Email')" /></td>
                    <td><x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus /></td>
                </tr>

                <!-- Password -->
                <tr>
                    <td><x-label for="password" :value="__('Password')" /></td>

                    <td><x-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" /></td>
                </tr>

                <!-- Remember Me -->
                <tr>
                    <td colspan="2">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">                     
                            <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </td>
                </tr>

                <tr>
                    <td colspan="2"><x-button class="loginButton">
                        {{ __('Log in') }}
                    </x-button></td>
                </tr>
            </form>
        </table>    
@stop
