<?php

namespace App\Console\Commands;

use AbstractFileCommand;

class InterfaceCommand extends AbstractFileCommand
{
    protected $signature = 'make:interface {CLASS_NAME} {--force}';
    protected $description = 'create new interface';
    public function __construct() {
        parent::__construct(
            'interface',
            'Interfaces',
            'Interface'
        );
    }
}
