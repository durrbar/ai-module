<?php

declare(strict_types=1);

namespace Modules\Ai\Console;

use Exception;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Modules\Ecommerce\Traits\ENVSetupTrait;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\info;
use function Laravel\Prompts\table;
use function Laravel\Prompts\text;

#[Signature('durrbar:open-ai-setup')]
#[Description('Setup OpenAI in .env file')]
class OpenAiSetupCommand extends Command
{
    use ENVSetupTrait;

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // Check if the .env file exists
        $this->CheckENVExistOrNot();
        $reconfigure = '';
        try {

            do {
                // Read the current .env content
                $envFilePath = base_path('.env');
                $envContent = File::get($envFilePath);
                $targetKeys = ['OPENAI_SECRET_KEY']; // Add the keys you want to display
                $data = $this->existingKeyValueInENV($targetKeys, $envContent);

                info('Please use arrow keys in keyboard for navigation.');
                if (confirm('Do you want to setup OpenAI?')) {
                    $openAi = text(label: 'Enter OpenAI secret key', default: $data[0][1], required: 'OpenAI secret key is required');

                    $this->OpenAiTable($openAi);

                    $confirmed = confirm(
                        label: 'Are you sure you want to update your OpenAI secret key?',
                        default: true,
                        yes: 'Yes, I accept',
                        no: 'No, I decline',
                        hint: 'The terms must be accepted to continue.'
                    );

                    if ($confirmed) {
                        $envContent = preg_replace(
                            '/(OPENAI_SECRET_KEY)=(.*)/',
                            "$1=$openAi",
                            $envContent
                        );

                        File::put($envFilePath, $envContent);
                        info('Congratulations! Your OpenAI configuration updated successfully!');
                    } else {
                        info('Your previous data (if any) is kept.');
                    }
                }
                info('If you think there is something wrong in the config, then you can reconfigure it.');
                $reconfigure = confirm('Do you want to reconfigure OpenAI secret key?', false);

                // If the user wants to reconfigure, the loop will continue
            } while ($reconfigure);
        } catch (Exception $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }

        return self::SUCCESS;
    }

    private function OpenAiTable(string $openAi): void
    {
        info('Please, check your credentials properly');
        table(['Key', 'Value'], [
            ['OPENAI_SECRET_KEY', $openAi],
        ]);
    }
}
