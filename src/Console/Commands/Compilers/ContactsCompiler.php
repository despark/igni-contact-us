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
     * @var array
     */
    protected $migrationReplacements = [
        ':table_name' => '',
        ':migration_class' => '',
    ];

    /**
     * @var array
     */
    protected $modelReplacements = [
        ':app_namespace' => '',
        ':table_name' => '',
    ];

    /**
     * @var array
     */
    protected $entitiesReplacements = [
        ':app_namespace' => '',
    ];

    /**
     * ContactsCompiler constructor.
     * @param $tableName
     */
    public function __construct($tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * @param $template
     * @param $suffix
     * @return string
     */
    public function render_migration($template, $suffix)
    {
        $this->migrationReplacements[':table_name'] = $this->tableName[$suffix];
        $this->migrationReplacements[':migration_class'] = 'Create' . str_plural(studly_case($this->tableName[$suffix])) . 'Table';

        $template = strtr($template, $this->migrationReplacements);

        return $template;
    }

    /**
     * @param $template
     * @param $suffix
     * @return string
     */
    public function render_model($template, $suffix)
    {
        $this->modelReplacements[':app_namespace'] = app()->getNamespace();
        $this->modelReplacements[':table_name'] = $this->tableName[$suffix];

        $template = strtr($template, $this->modelReplacements);

        return $template;
    }

    /**
     * @param $template
     * @return string
     */
    public function render_entities($template)
    {
        $this->entitiesReplacements[':app_namespace'] = app()->getNamespace();

        $template = strtr($template, $this->entitiesReplacements);

        return $template;
    }
}
