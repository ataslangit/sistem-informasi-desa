<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

class WritableLink extends BaseCommand
{
    protected $group       = 'Writable';
    protected $name        = 'writable:link';
    protected $description = 'Create the symbolic links configured for the application';

    public function run(array $params)
    {
        $filesystem = new Filesystem();

        try {
            $filesystem->symlink(WRITEPATH . 'uploads', FCPATH . 'uploads', true);
            CLI::write(CLI::color('The links have been created.', 'yellow'));
        } catch (IOExceptionInterface $exception) {
            CLI::write(CLI::color('An error occurred while creating symlink at ' . $exception->getPath(), 'red'));
        }
    }
}
