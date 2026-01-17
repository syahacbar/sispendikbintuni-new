<?php

namespace App\Services;

use App\Models\SysSetting;
use Illuminate\Support\Facades\Config;

class MailConfigService
{
    /**
     * Apply mail configuration from database settings
     */
    public function applyConfig(): void
    {
        $driver = SysSetting::getValue('mail_driver', 'smtp');

        switch ($driver) {
            case 'smtp':
                $this->configureSMTP();
                break;

            case 'sendgrid':
                $this->configureSendGrid();
                break;

            case 'mailgun':
                $this->configureMailgun();
                break;

            case 'ses':
                $this->configureSES();
                break;
        }
    }

    /**
     * Configure SMTP / cPanel mail driver
     */
    protected function configureSMTP(): void
    {
        $encryption = SysSetting::getValue('mail_encryption', 'tls');

        Config::set([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.transport' => 'smtp',
            'mail.mailers.smtp.host' => SysSetting::getValue('mail_host', env('MAIL_HOST', '127.0.0.1')),
            'mail.mailers.smtp.port' => SysSetting::getValue('mail_port', env('MAIL_PORT', 587)),
            'mail.mailers.smtp.encryption' => $encryption === 'none' ? null : $encryption,
            'mail.mailers.smtp.username' => SysSetting::getValue('mail_username', env('MAIL_USERNAME')),
            'mail.mailers.smtp.password' => SysSetting::getValue('mail_password', env('MAIL_PASSWORD')),
            'mail.from.address' => SysSetting::getValue('mail_from_address', env('MAIL_FROM_ADDRESS', 'hello@example.com')),
            'mail.from.name' => SysSetting::getValue('mail_from_name', env('MAIL_FROM_NAME', config('app.name'))),
        ]);
    }

    /**
     * Configure SendGrid mail driver
     */
    protected function configureSendGrid(): void
    {
        Config::set([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.transport' => 'smtp',
            'mail.mailers.smtp.host' => 'smtp.sendgrid.net',
            'mail.mailers.smtp.port' => 587,
            'mail.mailers.smtp.encryption' => 'tls',
            'mail.mailers.smtp.username' => 'apikey',
            'mail.mailers.smtp.password' => SysSetting::getValue('sendgrid_api_key', ''),
            'mail.from.address' => SysSetting::getValue('mail_from_address', env('MAIL_FROM_ADDRESS', 'hello@example.com')),
            'mail.from.name' => SysSetting::getValue('mail_from_name', env('MAIL_FROM_NAME', config('app.name'))),
        ]);
    }

    /**
     * Configure Mailgun mail driver
     */
    protected function configureMailgun(): void
    {
        Config::set([
            'mail.default' => 'mailgun',
            'services.mailgun.domain' => SysSetting::getValue('mailgun_domain', ''),
            'services.mailgun.secret' => SysSetting::getValue('mailgun_secret', ''),
            'services.mailgun.endpoint' => SysSetting::getValue('mailgun_endpoint', 'api.mailgun.net'),
            'mail.from.address' => SysSetting::getValue('mail_from_address', env('MAIL_FROM_ADDRESS', 'hello@example.com')),
            'mail.from.name' => SysSetting::getValue('mail_from_name', env('MAIL_FROM_NAME', config('app.name'))),
        ]);
    }

    /**
     * Configure Amazon SES mail driver
     */
    protected function configureSES(): void
    {
        Config::set([
            'mail.default' => 'ses',
            'services.ses.key' => SysSetting::getValue('aws_access_key_id', env('AWS_ACCESS_KEY_ID', '')),
            'services.ses.secret' => SysSetting::getValue('aws_secret_access_key', env('AWS_SECRET_ACCESS_KEY', '')),
            'services.ses.region' => SysSetting::getValue('aws_default_region', env('AWS_DEFAULT_REGION', 'us-east-1')),
            'services.ses.configuration_set' => SysSetting::getValue('aws_ses_configuration_set', null),
            'mail.from.address' => SysSetting::getValue('mail_from_address', env('MAIL_FROM_ADDRESS', 'hello@example.com')),
            'mail.from.name' => SysSetting::getValue('mail_from_name', env('MAIL_FROM_NAME', config('app.name'))),
        ]);
    }

    /**
     * Get current mail driver from database
     */
    public function getCurrentDriver(): string
    {
        return SysSetting::getValue('mail_driver', 'smtp');
    }

    /**
     * Check if mail configuration exists in database
     */
    public function hasConfig(): bool
    {
        return SysSetting::getValue('mail_driver') !== null;
    }
}
