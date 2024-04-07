<?php

namespace App\Console\Commands;

use FileCommand;

class InterfaceCommand extends FileCommand
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
