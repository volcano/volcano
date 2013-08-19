require 'pony'

# Send an email
def send_email(opts={})
  puts "Sending email to: #{opts[:to].join(", ")}"
  Pony.mail(opts)
end

# Check if a file exists by providing the full path to the expected file location
def local_file_exists?(full_path)
  File.exists?(full_path)
end

# Check if a directory exists by providing the full path to the expected location
def local_dir_exists?(full_path)
  File.directory?(full_path)
end

# Test to see if a file exists by providing 
# the full path to the expected file location
def remote_filesystem_check_exists?(flag, full_path)
  'true' == capture("if [ #{flag} #{full_path} ]; then echo 'true'; fi").strip
end

def remote_file_exists?(dir_path)
  remote_filesystem_check_exists?('-e', dir_path)
end

def remote_dir_exists?(dir_path)
  remote_filesystem_check_exists?('-d', dir_path)
end

# prompt the user with a message
def prompt(message)
  response = Capistrano::CLI.ui.ask "#{message} : "
  response
end

# prompt the user with a message and a default value
def prompt_with_default(message, default)
  response = prompt(message << " [#{default}]")
  response.empty? ? default : response
end

# prompt the user with a message and require a response
def prompt_with_required_response(message)
  response = prompt(message)
  raise "Response required to #{message}" if response.empty?
  response
end
