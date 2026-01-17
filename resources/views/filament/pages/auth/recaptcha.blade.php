@php
    $siteKey = \App\Models\SysSetting::getValue('recaptcha_site_key');
@endphp

@if(!empty($siteKey))
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <div class="flex justify-center" wire:ignore>
        <div class="g-recaptcha" data-sitekey="{{ $siteKey }}" data-callback="recaptchaCallback"></div>
    </div>

    <script>
        function recaptchaCallback(response) {
            @this.set('data.recaptcha', response);
        }
    </script>

    @error('data.recaptcha')
        <p class="text-danger-600 dark:text-danger-400 text-sm text-center mt-2">{{ $message }}</p>
    @enderror
@endif