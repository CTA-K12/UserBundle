##Getting Started With MesdUserBundle

The Symfony2 security component provides a flexible security framework that
allows you to load users from configuration, a database, or anywhere else
you can imagine. The MesdUserBundle builds on top of this to make it quick
and easy to store users in a database.

### Prerequisites

Symfony 2.3+


### Installation


#### Step 1: Download MesdUserBundle using composer

Add the MesdUserBundle to your composer.json file. You'll need to add the github url
under your "repositories" section, and add the bundle to your "require" section. Make
sure not to overwrite any existing repositories or requirements you already have in
place:

``` json
"repositories": [
    {
        "type" : "vcs",
        "url" : "https://github.com/MESD/UserBundle.git"
    }
],
"require": {
        "mesd/user-bundle": "dev-master"
    },
```

Now install the bundle with composer:

``` bash
$ composer update mesd/user-bundle
```

Composer will install the bundle to your project's `vendor/Mesd` directory.


#### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Mesd\UserBundle\MesdUserBundle(),
    );
}
```

#### Step 3: Create your User class

The goal of this bundle is to persist some `User` class to a database (MySql,
PostgreSQL, etc). Your first job is to create the `User` class
for your application. This class can look and act however you want: add any
properties or methods you find useful. This is *your* `User` class.

The bundle provides base classes which are already mapped for most fields
to make it easier to create your entity. Here is how you use it:

1. Extend the base `User` class from the ``Entity`` folder.
2. Map the `id` field. It must be protected as it is inherited from the parent class.

**Warning:**

> When you extend from the mapped superclass provided by the bundle, don't
> redefine the mapping for the other fields as it is provided by the bundle.

Your `User` class can live inside any bundle in your application. For example,
if you work at "Acme" company, then you might create a bundle called `AcmeUserBundle`
and place your `User` class in it.

In the following sections, you'll see examples of how your `User` class should
look.

**Note:**

> The doc uses a bundle named `AcmeUserBundle`. If you want to use the same
> name, you need to register it in your kernel. But you can, of course, place
> your user class in any bundle you want.

**Warning:**

> If you override the __construct() method in your User class, be sure
> to call parent::__construct(), as the base User class depends on
> this to initialize some fields.

##### Doctrine ORM User class

Your `User` class should live in the `Entity` namespace of your bundle and look like this to
start:

###### Option A) Annotations:

``` php
// src/Acme/UserBundle/Entity/User.php

namespace Acme\UserBundle\Entity;

use Mesd\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="acme_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
```

**Note:**

> `User` is a reserved keyword in SQL so you cannot use it as table name.


###### Option B) yaml:

If you use yml to configure Doctrine you must add two files. The Entity and the orm.yml:

```php
<?php
// src/Acme/UserBundle/Entity/User.php

namespace Acme\UserBundle\Entity;

use Mesd\UserBundle\Entity\User as BaseUser;

/**
 * User
 */
class User extends BaseUser
{
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
```
```yaml
# src/Acme/UserBundle/Resources/config/doctrine/User.orm.yml
Acme\UserBundle\Entity\User:
    type:  entity
    table: acme_user
    id:
        id:
            type: integer
            generator:
                strategy: AUTO

    manyToMany:
        roles:
            targetEntity: Role
            joinTable:
                name: demo_user_role
                joinColumns:
                    user_id:
                        referencedColumnName: id
                inverseJoinColumns:
                    role_id:
                        referencedColumnName: id
```


#### Step 3: Create your Role class

The Role entity will be *joined* to the User entity. Each ueser can belong
to as many roles as needed. The symfony2 security component will handle the
loading of roles at login and also provides methods for checking roles access.
We just need a place to store the roles and their user relationships.

1. Extend the base `Role` class from the ``Entity`` folder.
2. Map the `id` field. It must be protected as it is inherited from the parent class.

**Warning:**

> When you extend from the mapped superclass provided by the bundle, don't
> redefine the mapping for the other fields as it is provided by the bundle.
>
> If you override the __construct() method in your User class, be sure
> to call parent::__construct(), as the base User class depends on
> this to initialize some fields.

In the following sections, you'll see examples of how your `Role` class should
look.

**Note:**

> The doc uses a bundle named `AcmeUserBundle`. If you want to use the same
> name, you need to register it in your kernel. But you can, of course, place
> your user class in any bundle you want.
>
> The doc asumes you use the entity name `Role`. If you use a different entity
> name, you'll need to update the join in the `User` entity we already defined.



##### Doctrine ORM User class

Your `Role` class should live in the `Entity` namespace of your bundle and look like this to
start:

###### Option A) Annotations:

``` php
// src/Acme/UserBundle/Entity/Role.php

namespace Acme\UserBundle\Entity;

use Mesd\UserBundle\Entity\Role as BaseRole;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="acme_role")
 */
class Role extends BaseRole
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
```


###### Option B) yaml:

If you use yml to configure Doctrine you must add two files. The Entity and the orm.yml:

```php
<?php
// src/Acme/UserBundle/Entity/Role.php

namespace Acme\UserBundle\Entity;

use Mesd\UserBundle\Entity\Role as BaseRole;

/**
 * Role
 */
class Role extends BaseRole
{
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
```
```yaml
# src/Acme/UserBundle/Resources/config/doctrine/Role.orm.yml
Acme\UserBundle\Entity\Role:
    type:  entity
    table: acme_role
    id:
        id:
            type: integer
            generator:
                strategy: AUTO
```


#### Step 5: Configure your application's security.yml

In order for Symfony's security component to use the MesdUserBundle, you must
tell it to do so in the `security.yml` file. The `security.yml` file is where the
basic security configuration for your application is contained.

Below is a minimal example of the configuration necessary to use the MesdUserBundle
in your application:

**Note:**

> Make sure to set `default_target_path` directive, under `firewalls` -> `main`,
> to a route name that you want users directed to after they sucsessfully log in.

``` yaml
# app/config/security.yml
security:
    encoders:
        Mesd\UserBundle\Model\UserInterface: sha512

    role_hierarchy:
        ROLE_ADMIN:       ROLE_USER
        ROLE_SUPER_ADMIN: ROLE_ADMIN

    providers:
        mesd_user:
            mesd_user.user_provider.username

    firewalls:
        dev:
            pattern:  ^/(_(profiler|wdt)|css|images|js|ico)/
            security: false

        login:
            pattern:  ^/(login$|registration|reset)
            anonymous:  true

        main:
            pattern:    ^/
            form_login:
                csrf_provider: form.csrf_provider
                login_path: MesdUserBundle_login
                check_path: MesdUserBundle_check
                default_target_path: %your_applications_default_route%
            logout:
                path:   MesdUserBundle_logout
                target: MesdUserBundle_login

    #access_control:
        #- { path: ^/admin, roles: ROLE_ADMIN }
```

Lets walk through how this security configuration above is going to function:

###### Encoders:

The `encoders` section tells Symfony2 what class or interface to use to encode your users
passwords. This encoder we just configured uses the Secure Hash Algorithm wih a 512 bit
checksum. The MesdUserBundle also uses a cryptgraphic salt to encrypt the passwords it
stores.

###### Role Hierarchy:

`role_hierarchy` is used to establish role inheritance. In our configuration above,
`ROLE_ADMIN` automatically includes `ROLE_USER`. `ROLE_SUPER_ADMIN` includes `ROLE_ADMIN`,
and thus also includes `ROLE_USER` as well.

###### Providers:

Under the `providers` section, you are making the bundle's packaged user provider
service available via the alias `mesd_user`. The id of the bundle's user
provider service is `mesd_user.user_provider.username`. The `.username` configuration
sets the login form to expect the user to enter their username to log in. You could
change this to `mesd_user.user_provider.email` to force users to use their email
address, or `mesd_user.user_provider.username_email` to allow the user to login with
either credential.

###### Firewalls:

Next, examine the `firewalls` section. Firewalls specify application routes that
require authentication or allow access without the user having to authenticate (log in).
There are two types of configuration that allow a user to access routes without
authenticating `security: false` and `anonymous: true`. The difference is, with the
`security: false` directive no user token is created in the security context, while
the `anonymous: true` directive creates an anonymous user token in the security context.
Some of the security context methods require a user token to exist to function. An example
is the `remember_me` funcitonality.

Here we have declared a firewall named `dev` which watches for a route pattern that matches
the Symfony2 development tools, like the profiler and it's toolbar. The `security: false`
directive tells Symfony2 to not require authentication for these routes. This is helpful
if you want access to the Symfony2 profiler for troubleshooting routes even when you have
not logged in.

The `login` firewall, similarly to `dev`, makes sure Symfony2 doesn't require authentication
to reach the login, user registration, or password reset routes. The `MesdUserBundle` has
`remember_me` functionality enabled by default which will throw an exception if anonymous
access is not enabled on these routes.

The last firewall has been named `main` and has a pattern that covers every route in the
application. As such, it must come after the `login` and `dev` firewalls or it will prevent
access to the routes they cover. You can name your firewalls whatever you would like.
By specifying `form_login` you have told the Symfony2 framework that any time a request is
made to this firewall that leads to the user needing to authenticate, the user will be
redirected to a form where they're able to enter their credentials. The `csrf_provider`
directive tells the Symfony2 security component to enable [Cross-site request forgery](http://symfony.com/doc/current/cookbook/security/csrf_in_login_form.html)
protection on the login form. `login_path` specifies the route to the login form and
`check_path` specifies the route that checks the users credentails. The `default_target_path`
directive tells the security component what route the user should be sent to after a
sucsessfull login. Make sure you change the route name to a route in your application.
The `logout` key allows us to specify the `path` in our application that users will be routed
to for logout purposes. The `MesdUserBundle` has a route `MesdUserBundle_logout`
pre-configured for logout. The `target` directive tells the security component where to route
users after they logout. In this example above, we send them onto the login route
`MesdUserBundle_login`.

**Note:**

> Although we have used the form login mechanism in this example, the MesdUserBundle
> user provider service is compatible with many other authentication methods as well.
> Please read the Symfony2 Security component documentation for more information on the
> other types of authentication methods.

###### Access Controll:

The `access_control` section is where you specify the credentials necessary for users trying
to access specific parts of your application. You can see in the commented out example we have
specified that any request beginning with `/admin` will require a user to have the `ROLE_ADMIN`
role.

For more information on configuring the `security.yml` file please read the Symfony2
security component [documentation](http://symfony.com/doc/current/book/security.html).


#### Step 6: Configure the MesdUserBundle

Now that you have properly configured your application's `security.yml` to work
with the MesdUserBundle, the next step is to configure the bundle to work with
the specific entities you configured for your application.

Add the following configuration to your `config.yml` file:

``` yaml
# app/config/config.yml
mesd_user:
    user_class: Acme\UserBundle\Entity\User
    role_class: Acme\UserBundle\Entity\Role
```

Only two configuration values are required to use the bundle:

* The fully qualified class name (FQCN) of the `User` class which you created in Step 3.
* The fully qualified class name (FQCN) of the `Role` class which you created in Step 4.


#### Step 7: Import MesdUserBundle routing files

Now that you have activated and configured the bundle, all that is left to do is
import the MesdUserBundle routing files.

By importing the routing files you will have ready made pages for things such as
logging in, creating users, etc.

In YAML:

``` yaml
# app/config/routing.yml
MesdUserBundle_security:
    resource: "@MesdUserBundle/Resources/config/routing/security.yml"
```

#### Step8: Update your database schema

Now that the bundle is configured, the last thing you need to do is update your
database schema because you have added a new entity, the `User` class which you
created in Step 4.


``` bash
$ php app/console doctrine:schema:update --force
```


You now can login at `http://your_app.com/login`

### Next Steps

Now that you have completed the basic installation and configuration of the
MesdUserBundle, you are ready to learn about more advanced features and usages
of the bundle.

The following documents are available:

- [Using forms from the MesdPresentationBundle](using_with_mesd_presenation_bundle.md)
- [Using the Groups capability](using_groups.md)
- [Configuration Reference](config_reference.md)
