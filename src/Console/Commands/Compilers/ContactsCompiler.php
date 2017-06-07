<?php

namespace Despark\Cms\ContactUs\Console\Commands\Compilers;

/**
 * Class ContactsCompiler.
 */
class ContactsCompiler
{
    /**
     * @var string
     */
    protected $tableName;

    /**
     * @var string
     */
    protected $fullTableName;

    /**
     * @var array
     */
    protected $migrationReplacements = [
        ':table_name' => '',
        ':migration_class' => '',
    ];

    /**
     * @param Command $command
     * @param         $identifier
     * @param         $options
     *
     * @todo why setting options where we can get it from command? Either remove command or keep options
     */
    public function __construct($tableName, $fullTableName)
    {
        $this->tableName = $tableName;
        $this->fullTableName = $fullTableName;
    }

    /**
     * @param $template
     *
     * @return string
     */
    public function render_migration($template, $suffix)
    {
        $this->migrationReplacements[':table_name'] = str_plural($this->tableName[$suffix]);
        $this->migrationReplacements[':migration_class'] = 'Create'.str_plural(studly_case($this->tableName[$suffix])).'Table';

        $template = strtr($template, $this->migrationReplacements);

        return $template;
    }
}
