require 'etc'
require 'erb'
require 'json'

namespace :release do
  desc "Create the git log from previous to current commit history"
  task :set_release_notes do
      if not remote_file_exists?("#{release_path}/REVISION")
        return
      end
      
      # set(:git_final_sha, capture("cd #{release_path}; git rev-parse --verify HEAD").strip)
      set(:git_final_sha, capture("cat #{release_path}/REVISION").strip)

      git_log_command = "git log"

      if exists?(:git_log_options)
        git_log_command << " #{git_log_options}"
      end

      if exists?(:git_initial_sha)
        git_commits_range = "#{git_initial_sha}..#{git_final_sha}"
      else
        git_commits_range = git_final_sha
        # First release (prints 1 commits)
        git_log_command << " --max-count=1"
      end

      git_log_command << " #{git_commits_range}"
      
      # Executes git login local shell
      logger.important "Release notes generated with: #{git_log_command}"
      git_log = run_locally(git_log_command)
      set :release_notes, git_log
      set :deployed_commit, git_final_sha
  end

  desc "Send a deployment notification"
  task :send_release_notification do
    msg = "#{Etc.getpwuid.name} deployed #{deployed_commit} to #{stage}"

    if exists?(:release_notes) and not release_notes.empty?
      msg << "\nRelease Notes:\n#{release_notes}"
    else
      logger.important "Release notes where empty for #{deployed_commit}"
    end

    send_email( email_options.merge!( { :body => msg } ))
  end

  desc 'Add git tag for each successful deployment'
  task :tag_release_deployment, :except => { :no_release => true } do
    tag_prefix = "#{stage}-"
    tag_name = tag_prefix << git.abbreviated_revision_for_tag("#{deployed_commit}")
    
    if !git.tag_exists?(tag_name)
      logger.important "Tagging #{deployed_commit} for #{stage} deployment"

      run_locally("git tag -a #{tag_name} -m '#{Etc.getpwuid.name} deployed #{deployed_commit} to #{stage}'")
      run_locally("git push --tags") if git.has_remote?
    else
      logger.important "Tag #{tag_name} all ready exists"
    end
  end

  desc "Fuel oil script calls"
  task :fuel_oil_scripts do
  fuel_env = ("#{stage}".eql?('staging')) ? "stage" : "#{stage}"

    logger.important "Running db migration on #{fuel_env}"
    run "cd #{latest_release} && FUEL_ENV='#{fuel_env}' /usr/bin/php oil refine migrate", :once => true
    
    logger.important "Running session create on #{fuel_env}"
    run "cd #{latest_release} && FUEL_ENV='#{fuel_env}' /usr/bin/php oil refine session:create", :once => true
  end

  desc "Generate application config"
  task :generate_db_conf_file do
    logger.important "Generating config file for #{stage}"
    
    run "#{try_sudo} mkdir -p #{config_dir}" unless remote_dir_exists?("#{config_dir}")
    run "#{try_sudo} chown -R #{www_user}:#{www_group} #{deploy_to}"
    run "#{try_sudo} chmod -R 775 #{deploy_to}"

    db_config = {}
    db_config[:host] = prompt("DB host")
    db_config[:name] = prompt("DB name")
    db_config[:user] = prompt("DB username")
    db_config[:pass] = prompt("DB password")

    template = <<-ERB.gsub(/^[ \t]{6}/, '')
      <?php

      return array(
        'default' => array(
          'connection' => array(
            'host' => '<%= db_config[:host] %>',
            'name' => '<%= db_config[:name] %>',
            'user' => '<%= db_config[:user] %>',
            'pass' => '<%= db_config[:pass] %>',
          ),
        ),
      );
    ERB

    template = ERB.new(template).result(binding)
    put template, "#{config_dir}/db.php"
    run "#{try_sudo} chown -R #{www_user}:#{www_group} #{config_dir}"

  end

  desc "graceful restart httpd"
  task :httpd_graceful_restart do
    run "#{try_sudo} /etc/init.d/httpd graceful"
  end

end # end namespace release

