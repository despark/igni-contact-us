<?php

namespace Despark\Cms\ContactUs\Console\Commands;

use Despark\Cms\ContactUs\Console\Commands\Compilers\ContactsCompiler;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use File;

/**
 * Class InstallCommand.
 */
class InstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'igni:make:contacts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create necessary files for CMS Contacts resource.';

    /**
     * Table name.
     *
     * @var string|null
     */
    protected $tablePrefix;

    /**
     * Table name.
     *
     * @var array
     */
    protected $tableName;

    /**
     * Full table name.
     *
     * @var array
     */
    protected $fullTableName;

    /**
     * Compiler.
     *
     * @var
     */
    protected $compiler;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
        $this->tablePrefix = config('ignicms.igniTablesPrefix');
        $this->tableName['contacts'] = 'contacts';
        $this->fullTableName['contacts'] = $this->tablePrefix ? $this->tablePrefix.'_'.$this->tableName['contacts'] : $this->tableName['contacts'];
        $this->tableName['contact_messages'] = 'contact_messages';
        $this->fullTableName['contact_messages'] = $this->tablePrefix ? $this->tablePrefix.'_'.$this->tableName['contact_messages'] : $this->tableName['contact_messages'];
    }

    /**
     * Execute the command.
     */
    public function handle()
    {
        if (Schema::hasTable($this->fullTableName['contacts'])) {
            $this->tableName['contacts'] = $this->ask('The table name '.$this->fullTableName['contacts'].' already exists! Please enter a new one without it\'s prefix:');
            $this->fullTableName['contacts'] = $this->tablePrefix ? $this->tablePrefix.'_'.$this->tableName['contacts'] : $this->tableName['contacts'];
        }

        if (Schema::hasTable($this->fullTableName['contact_messages'])) {
            $this->tableName['contact_messages'] = $this->ask('The table name '.$this->fullTableName['contact_messages'].' already exists! Please enter a new one without it\'s prefix:');
            $this->fullTableName['contact_messages'] = $this->tablePrefix ? $this->tablePrefix.'_'.$this->tableName['contact_messages'] : $this->tableName['contact_messages'];
        }

        // Publish config files
        $this->info('Publishing Igni Contact Us config files..'.PHP_EOL);
        $this->call('vendor:publish', [
            '--provider' => \Despark\Cms\ContactUs\Providers\IgniContactUsServiceProvider::class,
            '--tag' => ['config'],
        ]);
        $this->askForGoogleMaps();
        $this->info(PHP_EOL.'Dumping autoloader..');
        $this->info(exec('composer dumpautoload'));
        $this->compiler = new ContactsCompiler($this->tableName, $this->fullTableName);
        $this->createResource('migration', 'contact_messages');
        $this->createResource('migration', 'contacts');
        $this->info('Migrating..'.PHP_EOL);
        $this->call('migrate');
        if ($this->confirm('Do you want to insert dummy data?')) {
            $this->info('Seeding..'.PHP_EOL);
            $this->seedContact();
        }
        $this->seedContactMessage();
        $this->info('Fantastic! You are good to go :)'.PHP_EOL);
    }

    /**
     * @param $type
     */
    protected function createResource($type, $suffix = null)
    {
        $template = $this->getTemplate($type, $suffix);
        $template = $suffix ? $this->compiler->{'render_'.$type}($template, $suffix) : $this->compiler->{'render_'.$type}($template);
        $path = config('ignicms.paths.'.$type);
        $filename = $suffix ? $this->{$type.'_name'}($suffix).'.php' : $this->{$type.'_name'}().'.php';
        $this->saveResult($template, $path, $filename);
    }

    /**
     * @param $type
     *
     * @return string
     */
    public function getTemplate($type, $suffix = null)
    {
        if ($suffix) {
            return file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'stubs'.DIRECTORY_SEPARATOR.$type.'_'.$suffix.'.stub');
        }

        return file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'stubs'.DIRECTORY_SEPARATOR.$type.'.stub');
    }

    /**
     * @param $template
     * @param $path
     * @param $filename
     */
    protected function saveResult($template, $path, $filename)
    {
        $file = $path.DIRECTORY_SEPARATOR.$filename;

        if (File::exists($file)) {
            $result = $this->confirm('File "'.$filename.'" already exist. Overwrite?', false);
            if (! $result) {
                return;
            }
        }
        File::put($file, $template);
        $this->info('File "'.$filename.'" was created.');
    }

    /**
     * @return string
     */
    public function migration_name($suffix)
    {
        return date('Y_m_d_His').'_create_'.str_plural($this->tableName[$suffix]).'_table';
    }

    public function seedContact()
    {
        $contact = [
            'type' => 'email',
            'content' => 'Example content for email contact.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        \DB::table(str_plural($this->fullTableName['contacts']))->insert($contact);
    }

    public function seedContactMessage()
    {
        $contactMessage = [
            'name' => 'Anton Geshev',
            'email' => 'ageshev@despark.com',
            'phone' => '1234567890',
            'message' => 'Hello from Tony :)',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        \DB::table(str_plural($this->fullTableName['contact_messages']))->insert($contactMessage);
    }

    public function askForGoogleMaps()
    {
        if ($this->confirm('Do you need Google Maps in your page? (You\'d need to provide an API key that can be generated for free from here: https://developers.google.com/maps/documentation/javascript/get-api-key)')) {
            $apiKey = $this->ask('Enter your Google API key:');
            $variable = PHP_EOL.PHP_EOL.'GOOGLE_MAPS_API_KEY='.$apiKey;
            file_put_contents(base_path('.env'), $variable, FILE_APPEND | LOCK_EX);
        }
    }
}
