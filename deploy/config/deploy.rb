require 'rubygems'
require 'railsless-deploy'
require 'capistrano_colors'
require 'etc'
require File.join(File.dirname(__FILE__), '/lib/capistrano-tools') 

default_run_options[:pty] = true

set :application, "volcano"

set :stages, %w(staging production)
set :default_stage, "staging"
set :stage_dir, File.join( File.dirname(__FILE__), '/deploy')
require 'capistrano/ext/multistage'

set :scm, "git"
set :repository, "ssh://git@code.onesite.com/volcano/crm.git"
set :branch, "stage"
set :git_enable_submodules, 1
set :deploy_via, :remote_cache

set :user, "deploy"
set :use_sudo, true
set :keep_releases, 5

set :deploy_to, "/var/www/volcano.catalog.com"
set :current_path, "#{deploy_to}/current"
set :releases_path, "#{deploy_to}/releases"
set :shared_path, "#{deploy_to}/shared"
set :config_dir, "#{deploy_to}/config"

set :www_user, "apache"
set :www_group, "apache" 

set :default_environment, {
  'PATH' => "$PATH:/bin:/sbin:/usr/bin:/usr/sbin:/usr/local/bin:/usr/local/sbin"
}

set :git_log_options, "--abbrev-commit --no-merges"

set :ssh_options, {
    :user => Etc.getpwuid.name,
    :config => File.join(Etc.getpwuid.dir, ".ssh", "config"),
    :keys => [
      File.join(Etc.getpwuid.dir, ".ssh", "id_rsa"),
      File.join(Etc.getpwuid.dir, ".ssh", "com_volcano_id_rsa"),
      File.join(Etc.getpwuid.dir, ".ssh", "com_volcano_deploy_id_rsa")
    ],
}

before :deploy do
  unless exists?(:deploy_to)
    raise "usage: cap <env> <command> <options>"
    raise "  env       staging=default, production."
    raise "  command   'cap -T' for full list of commands"
  end
end
