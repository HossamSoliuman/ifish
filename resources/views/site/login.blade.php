@extends('site.layouts.auth')
@section('title', __('site.login.title') . ' - ' . __('site.meta.title'))

@push('styles')
<style>
    .hud-screen {
        position: relative;
        min-height: 100vh;
        background:
            radial-gradient(900px 500px at 75% -10%, rgba(54, 117, 194, .22), transparent 60%),
            radial-gradient(700px 600px at 10% 110%, rgba(54, 117, 194, .14), transparent 60%),
            linear-gradient(160deg, #0a1b30 0%, #0b1f37 45%, #081627 100%);
        overflow: hidden;
    }
    .hud-screen::before {
        content: "";
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(120, 170, 230, .06) 1px, transparent 1px),
            linear-gradient(90deg, rgba(120, 170, 230, .06) 1px, transparent 1px);
        background-size: 44px 44px;
        mask-image: radial-gradient(circle at 50% 40%, #000 55%, transparent 100%);
        -webkit-mask-image: radial-gradient(circle at 50% 40%, #000 55%, transparent 100%);
        pointer-events: none;
    }
    .hud-screen::after {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, transparent, #3675c2 40%, #4bafe5 60%, transparent);
        opacity: .8;
    }
    .hud-card {
        position: relative;
        background: linear-gradient(180deg, rgba(18, 41, 70, .72), rgba(10, 26, 46, .72));
        border: 1px solid rgba(120, 170, 230, .18);
        backdrop-filter: blur(6px);
        box-shadow: 0 24px 60px rgba(0, 0, 0, .45), inset 0 1px 0 rgba(255, 255, 255, .04);
    }
    .hud-card .brk {
        position: absolute;
        width: 22px;
        height: 22px;
        border: 2px solid rgba(120, 180, 240, .65);
        pointer-events: none;
    }
    .hud-card .brk-tl { top: -1px; inset-inline-start: -1px; border-inline-end: 0; border-bottom: 0; }
    .hud-card .brk-tr { top: -1px; inset-inline-end: -1px; border-inline-start: 0; border-bottom: 0; }
    .hud-card .brk-bl { bottom: -1px; inset-inline-start: -1px; border-inline-end: 0; border-top: 0; }
    .hud-card .brk-br { bottom: -1px; inset-inline-end: -1px; border-inline-start: 0; border-top: 0; }
</style>
@endpush

@section('content')
<main class="hud-screen flex items-center justify-center px-4 py-10">
    <div class="relative w-full max-w-md">
        <div class="hud-card rounded-md p-8">
            <span class="brk brk-tl"></span>
            <span class="brk brk-tr"></span>
            <span class="brk brk-bl"></span>
            <span class="brk brk-br"></span>

            <div class="flex justify-center">
                <img src="{{ asset('site/assets/logo-white.png') }}" alt="{{ __('site.aria.logo') }}" class="h-fit w-40 object-contain">
            </div>

            <h1 class="mt-6 text-center text-2xl font-extrabold text-white">{{ __('site.login.title') }}</h1>
            <p class="mt-2 text-center text-sm text-slate-400">{{ __('site.login.subtitle') }}</p>

            <form id="loginForm" action="{{ route('frontend.login') }}" method="post" class="mt-8 space-y-4">
                @csrf
                <div>
                    <label class="mb-2 block text-sm font-semibold text-[#7db0ec]">{{ __('site.login.email') }}</label>
                    <input id="emailInput" name="email" type="email" dir="rtl" placeholder="{{ __('site.login.email_placeholder') }}" value="{{ old('email') }}"
                        class="h-11 w-full rounded-md border border-[#3675c2]/30 bg-[#0a1b30]/70 px-4 text-sm text-slate-100 outline-none ring-[#3675c2]/40 placeholder:text-slate-500 focus:border-[#4bafe5] focus:ring-4" />
                    <p id="emailInputError" class="mt-1 text-xs text-rose-400 hidden"></p>
                    @error('email')<p class="mt-1 text-xs text-rose-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-[#7db0ec]">{{ __('site.login.password') }}</label>
                    <div class="relative">
                        <input id="passwordInput" name="password" type="password" placeholder="{{ __('site.login.password_placeholder') }}"
                            class="h-11 w-full rounded-md border border-[#3675c2]/30 bg-[#0a1b30]/70 px-4 pe-11 text-sm text-slate-100 outline-none ring-[#3675c2]/40 placeholder:text-slate-500 focus:border-[#4bafe5] focus:ring-4" />
                        <button id="togglePassword" type="button" class="absolute inset-y-0 left-2 inline-flex items-center justify-center rounded-md px-2 text-slate-400 hover:text-slate-200" aria-label="{{ __('site.aria.toggle_password') }}">
                            <svg id="eyeIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" /><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" /></svg>
                        </button>
                    </div>
                    <p id="passwordInputError" class="mt-1 text-xs text-rose-400 hidden"></p>
                    @error('password')<p class="mt-1 text-xs text-rose-400">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center pt-1 text-sm">
                    <label class="inline-flex items-center gap-2 text-slate-300">
                        <input id="rememberMe" name="remember" type="checkbox" value="1" class="h-4 w-4 rounded border-[#3675c2]/40 bg-[#0a1b30] text-[#3675c2] focus:ring-[#3675c2]" {{ old('remember') ? 'checked' : '' }} />
                        {{ __('site.login.remember') }}
                    </label>
                </div>
                <button type="submit" class="mt-2 h-11 w-full rounded-md bg-[linear-gradient(98.7deg,#3778BC_19.22%,#4BAEE5_73.07%)] text-sm font-semibold text-white shadow-lg shadow-[#3675c2]/30 hover:opacity-90 focus:outline-none focus:ring-4 focus:ring-[#3675c2]/40 transition">{{ __('site.login.submit') }}</button>
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
        if (input) { input.classList.remove('border-rose-500'); input.classList.add('border-[#3675c2]/30'); }
        if (error) error.classList.add('hidden');
    }
    if (emailInput) emailInput.addEventListener('input', () => clearError('emailInput'));
    if (passwordInput) passwordInput.addEventListener('input', () => clearError('passwordInput'));
})();
</script>
@endpush
@endsection
