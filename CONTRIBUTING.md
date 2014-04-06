## Contributing

#### General Changes
1. [Fork the repository](https://help.github.com/articles/fork-a-repo)
2. [Create a topic branch](http://learn.github.com/p/branching.html)
3. [Add, commit and push your changes](http://git-scm.com/book/en/Git-Basics-Getting-a-Git-Repository)
4. [Submit a pull request](https://help.github.com/articles/using-pull-requests)

#### Payment Gateways

Volcano's Payment Gateway system utilizes the [adapter design pattern](http://en.wikipedia.org/wiki/Adapter_pattern). The adapter allows the system to interface with a variety of billing drivers (Authorize.net, Stripe, PayPal, etc). Currently, Authorize.net is the only supported payment gateway. However, additional gateways can easily be added:

1. Create a new directory within `/fuel/app/classes/gateway` for the new gateway driver.
2. Within this new directory, add `driver.php`, `customer.php`, `paymentmethod.php` and `transaction.php`  files. Each of these files should contain CRUD logic specific to the new driver. Refer to the authorizenet driver as a general guide for how to name the classes and structure code.
