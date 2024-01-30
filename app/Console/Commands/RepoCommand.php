<?php

namespace App\Console\Commands;

use AbstractFileCommand;
use Illuminate\Console\Command;

class RepoCommand extends AbstractFileCommand
{
    protected $signature = 'make:repo {CLASS_NAME} {--force}';
    protected $description = 'create new repo';
    public function __construct() {
        parent::__construct(
            'repository',
            'Repositories',
            'Repository'
        );
    }
}
