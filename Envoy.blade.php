@servers(['web' => 'user@your.server.com'])

@setup
    $repository = 'your-repository-url';
    $releases_dir = '/var/www/releases';
    $app_dir = '/var/www/app';
    $release = date('YmdHis');
@endsetup

@task('deploy')
    cd {{ $releases_dir }}
    git clone {{ $repository }} {{ $release }}
    cd {{ $release }}
    composer install --prefer-dist --no-scripts
    php artisan migrate --force
    php artisan cache:clear
    ln -nfs {{ $releases_dir }}/{{ $release }} {{ $app_dir }}
@endtask

@task('rollback')
    cd {{ $app_dir }}
    @if (is_link({{ $app_dir }}))
        rm {{ $app_dir }}
    @endif
@endtask
