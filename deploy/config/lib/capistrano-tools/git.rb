namespace :git do  
  desc 'Verify necessary variables are set and branches are available and git repo is clean'
  task :verify_repo, :except => { :no_release => true } do
    unless exists?(:branch) && exists?(:stage)
      logger.important "Capistrano Deploytags requires that :branch and :stage be defined."
      raise 'define :branch and :stage'
    end

    logger.important "Preparing to deploy HEAD from branch '#{branch}' to '#{stage}'"

    if pending_git_changes?
      logger.important "Whoa there cowboy! Dirty trees can't deploy."
      
      response = prompt_with_default("Run anyways?", "y")

      case response.strip
        when 'Y', 'YES', 'Yes', 'y', 'yes'
          logger.important "Forced deploy of dirty tree '#{branch}' to '#{stage}'"
        else
          raise 'Dirty tree'
      end
    end
    
    run_locally("git checkout #{branch}")
    run_locally("git pull origin #{branch}") if has_remote?
  end

  def pending_git_changes?
    # Do we have any changes vs HEAD on deployment branch?
    logger.important "Checking for pending changes with: git fetch && git diff #{branch} --shortstat"
    !(`git fetch && git diff #{branch} --shortstat`.strip.empty?)
  end

  def tag_exists?(tag)
    !(`git tag -l #{tag}`.strip.empty?)
  end

  def has_remote?
    !(`git remote`.strip.empty?)
  end

  def abbreviated_revision_for_tag(tag="")
    rev = run_locally("git rev-parse --short #{tag}").strip
    rev
  end

end #end namespace git
