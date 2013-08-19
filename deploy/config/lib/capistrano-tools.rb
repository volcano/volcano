require 'capistrano'

module Capistrano
  module ReleaseTools
  
    def self.load_into(configuration)
      configuration.load do  

        load_paths.push File.expand_path('../', __FILE__)

        Dir[File.join(File.dirname(__FILE__), 'capistrano-tools', '*')].each do |file|
          load file
        end

        before :deploy do
          # Make sure we are deploying from a clean repo on production
          if !"#{stage}".eql?('dev')
            git.verify_repo
          end

          # Set the initial git revision
          if not remote_file_exists?("#{current_path}/REVISION")
            logger.important "Initial Deployment"
            # setup the release folder structure
            deploy.setup
          end

          # Get the sudoers password stored now so as to not be prompted for it later
          run "#{sudo} /usr/bin/uptime"
        end

        after "deploy:setup" do
          logger.important "Setting up #{stage}"
          if !"#{stage}".eql?('dev')
            # Set the correct permissions for the web user
            run "#{try_sudo} chown -R #{www_user}:#{www_group} #{deploy_to}"
          end
        end
        
        after "deploy:update" do 
          # set(:git_initial_sha, capture("cd #{current_path}; git rev-parse --verify HEAD").strip)
          if remote_file_exists?("#{previous_release}/REVISION")
            set(:git_initial_sha, capture("cat #{previous_release}/REVISION").strip)
            logger.important "Starting git revision: '#{git_initial_sha}'"
          end

          # Finalize application setup needed by fuel 
          release.fuel_oil_scripts

          # fix release dir permissions
          run "#{try_sudo} chown -R #{www_user}:#{www_group} #{latest_release}"
        end

        after :deploy do
          # httpd graceful restart
          release.httpd_graceful_restart
          
          # Send release notes
          release.set_release_notes
          
          # remove old versions of code (@see :keep_releases variable used per #{branch})
          deploy.cleanup 
          # email notification about the release
          release.send_release_notification
          # tag the deployment if it is production
          if "#{stage}".eql?('prod')
            release.tag_release_deployment
          end
        end

      end # end configuration.load
    end # end self.load_into
  end # end ReleaseTools module
end # end Capistrano module

Capistrano.plugin :reltools, Capistrano::ReleaseTools

if Capistrano::Configuration.instance
  Capistrano::ReleaseTools.load_into(Capistrano::Configuration.instance(:must_exist))
end
