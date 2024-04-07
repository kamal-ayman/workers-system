<?php

namespace App\Console\Commands;

use FileCommand;

class ServiceCommand extends FileCommand
{
    protected $signature = 'make:service {CLASS_NAME} {--force}';
    protected $description = 'create new class of service';
    public function __construct() {
        parent::__construct(
            'servicepattern',
            'Services',
            'Service'
        );
    }
}
