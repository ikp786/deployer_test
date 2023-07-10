<?php
namespace Deployer;

require 'recipe/laravel.php';

    // Define a server for deployment.
// host('ubuntu@3.108.217.141')
// host('http://127.0.0.1')
localhost()
->set('deploy_path', '/var/www/html/deployertest'); // Your server path to deploy
//->identityFile('~/.ssh/id_rsa');


// Set the repository from which to pull your project's code
set('repository', 'https://github.com/ikp786/deployer_test.git');

// Specify the branch to deploy, if different from the default branch
set('branch', 'master');

// Custom task to run database migrations
task('deploy:migrate', function () {
    within('{{release_path}}', function () {
        run('{{bin/php}} artisan migrate --force');
    });
});

// Custom task to set up Laravel's task scheduler
task('deploy:schedule', function () {
    $deployPath = '/var/www/html/deployertest/current';
    run("cd {$deployPath} && (crontab -l ; echo '* * * * * cd {$deployPath} && php artisan schedule:run >> /dev/null 2>&1') | sort - | uniq - | crontab -");
})->desc('Add schedule:run to crontab');

// Hook onto existing tasks
after('deploy:symlink', 'deploy:schedule');
after('deploy:vendors', 'deploy:migrate');

// Main task
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'deploy:migrate',
    'deploy:symlink',
    'deploy:unlock',    
])->desc('Deploy your project');
