set :branch, "stage"

role :server, "volcano.stage.catalog.com"

set :email_options, {
  :to => ["volcano@catalog.com"],
  :from   => "volcano@catalog.com",
  :reply_to => "volcano@catalog.com",
  :sender => "Volcano",
  :subject => "Deploying #{application} to staging",
  :via => :sendmail
}
