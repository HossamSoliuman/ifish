@extends('site.layouts.auth')
@section('title', __('site.login.title') . ' - ' . __('site.meta.title'))

@section('content')
<main class="flex min-h-screen items-center justify-center bg-[#1d2025] px-4 py-10">
    <div class="w-full max-w-md">
        <div class="rounded-xl border border-white/10 bg-[#2b3035] p-8 shadow-2xl">
            <div class="flex justify-center">
                <img src="{{ asset('site/assets/logo-white.png') }}" alt="{{ __('site.aria.logo') }}" class="h-fit w-40 object-contain">
            </div>

            <h1 class="mt-6 text-center text-2xl font-extrabold text-white">{{ __('site.login.title') }}</h1>
            <p class="mt-2 text-center text-sm text-slate-400">{{ __('site.login.subtitle') }}</p>

            <form id="loginForm" action="{{ route('frontend.login') }}" method="post" class="mt-8 space-y-4">
                @csrf
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200">{{ __('site.login.email') }}</label>
                    <input id="emailInput" name="email" type="email" dir="rtl" placeholder="{{ __('site.login.email_placeholder') }}" value="{{ old('email') }}"
                        class="h-11 w-full rounded-md border border-white/10 bg-[#212529] px-4 text-sm text-slate-100 outline-none ring-[#3675c2]/40 placeholder:text-slate-500 focus:border-[#3675c2] focus:ring-4" />
                    <p id="emailInputError" class="mt-1 text-xs text-rose-400 hidden"></p>
                    @error('email')<p class="mt-1 text-xs text-rose-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200">{{ __('site.login.password') }}</label>
                    <div class="relative">
                        <input id="passwordInput" name="password" type="password" placeholder="{{ __('site.login.password_placeholder') }}"
                            class="h-11 w-full rounded-md border border-white/10 bg-[#212529] px-4 pe-11 text-sm text-slate-100 outline-none ring-[#3675c2]/40 placeholder:text-slate-500 focus:border-[#3675c2] focus:ring-4" />
                        <button id="togglePassword" type="button" class="absolute inset-y-0 left-2 inline-flex items-center justify-center rounded-md px-2 text-slate-400 hover:text-slate-200" aria-label="{{ __('site.aria.toggle_password') }}">
                            <svg id="eyeIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" /><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" /></svg>
                        </button>
                    </div>
                    <p id="passwordInputError" class="mt-1 text-xs text-rose-400 hidden"></p>
                    @error('password')<p class="mt-1 text-xs text-rose-400">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center pt-1 text-sm">
                    <label class="inline-flex items-center gap-2 text-slate-300">
                        <input id="rememberMe" name="remember" type="checkbox" value="1" class="h-4 w-4 rounded border-white/20 bg-[#212529] text-[#3675c2] focus:ring-[#3675c2]" {{ old('remember') ? 'checked' : '' }} />
                        {{ __('site.login.remember') }}
                    </label>
                </div>
                <button type="submit" class="mt-2 h-11 w-full rounded-md bg-[#3675c2] text-sm font-semibold text-white shadow-sm hover:bg-[#2f66ab] focus:outline-none focus:ring-4 focus:ring-[#3675c2]/40">{{ __('site.login.submit') }}</button>
                <p id="formMsg" class="hidden text-center text-sm"></p>
            </form>
        </div>
    </div>
</main>

@push('scripts')
<script>
(function() {
    const passwordInput = document.getElementById("passwordInput");
    const togglePassword = document.getElementById("togglePassword");
    if (togglePassword) togglePassword.addEventListener("click", () => { passwordInput.type = passwordInput.type === "password" ? "text" : "password"; });

    const emailInput = document.getElementById("emailInput");
    const rememberMe = document.getElementById("rememberMe");
    const savedEmail = localStorage.getItem("ifish_email");
    if (savedEmail && emailInput) { emailInput.value = savedEmail; if (rememberMe) rememberMe.checked = true; }
    if (rememberMe) rememberMe.addEventListener("change", () => { if (!rememberMe.checked) localStorage.removeItem("ifish_email"); else if (emailInput) localStorage.setItem("ifish_email", emailInput.value.trim()); });
    if (emailInput) emailInput.addEventListener("input", () => { if (rememberMe && rememberMe.checked) localStorage.setItem("ifish_email", emailInput.value.trim()); });

    function clearError(inputId) {
        const input = document.getElementById(inputId);
        const error = document.getElementById(inputId + 'Error');
        if (input) { input.classList.remove('border-rose-500'); input.classList.add('border-white/10'); }
        if (error) error.classList.add('hidden');
    }
    if (emailInput) emailInput.addEventListener('input', () => clearError('emailInput'));
    if (passwordInput) passwordInput.addEventListener('input', () => clearError('passwordInput'));
})();
</script>
@endpush
@endsection
