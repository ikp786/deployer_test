<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'https://github.com/ikp786/deployer_test.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts
host('134.209.179.69')
    ->user('master_fgjrkdzdqn')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '/home/master/applications/tdnhgbweeq/public_html');

// Hooks

after('deploy:failed', 'deploy:unlock');
