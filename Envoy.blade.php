@servers(['web' => 'deployer@176.97.241.234 -p 2222'])

@setup
    $repository = 'git@gitlab.com:mdojcar/proscholy.cz.git';
    $releases_dir = '/var/www/proscholy.cz/releases';
    $app_dir = '/var/www/proscholy.cz';
    $release = date('YmdHis');
    $new_release_dir = $releases_dir .'/'. $release;
@endsetup

@story('deploy')
    clone_repository
    run_composer
    update_yarn
    give_permissions
    update_symlinks
@endstory

@task('clone_repository')
    echo 'Cloning repository'
    [ -d {{ $releases_dir }} ] || mkdir {{ $releases_dir }}
    git clone --depth 1 {{ $repository }} {{ $new_release_dir }}
    cd {{ $new_release_dir }}
    git reset --hard master
@endtask

@task('update_yarn')
    echo 'Linking node_modules directory'
    ln -nfs {{ $app_dir }}/node_modules {{ $new_release_dir }}/node_modules

    echo "Updating yarn node_modules folder ({{ $release }})"
    cd {{ $releases_dir }}
    yarn install
@endtask

@task('run_composer')
    echo "Starting deployment ({{ $release }})"
    cd {{ $new_release_dir }}
    composer install --prefer-dist --no-scripts -q -o
@endtask

@task('update_symlinks')
    echo "Linking storage directory"
    rm -rf {{ $new_release_dir }}/storage
    ln -nfs {{ $app_dir }}/storage {{ $new_release_dir }}/storage

    echo 'Linking .env file'
    ln -nfs {{ $app_dir }}/.env {{ $new_release_dir }}/.env

    echo 'Linking current release'
    ln -nfs {{ $new_release_dir }} {{ $app_dir }}/current
@endtask

@task('give_permissions')
    echo "Giving permissions for apache to access the storage and vendor folders"
    chown -R www-data:www-data {{ $new_release_dir }}/storage {{ $new_release_dir }}/vendor
@endtask

{{-- @task('list', ['on' => 'web'])
    cd /var/www
    ls -l
@endtask --}}

