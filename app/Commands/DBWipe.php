<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Database;

class DBWipe extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Database';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'db:wipe';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Drop all tables';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'db:wipe';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     */
    public function run(array $params)
    {
        $baseConnection = Database::connect();
        $tables         = $baseConnection->listTables();
        $forge          = \Config\Database::forge();

        foreach ($tables as $table) {
            $forge->dropTable($table);
        }

        CLI::write(CLI::color('Dropped all tables successfully.', 'green'));
    }
}
