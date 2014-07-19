Using the MesdPresentationBundle
=================================

The `MesdUserBundle` forms and templates do not have CSS layout or presentation embedded.
This is done intentionally so you can style the templates to match your application.

If you would like some forms that are pre-built with CSS layouts and presentation
components, you could take a look at the [ MesdPresentationBundle ](https://github.com/MESD/PresentationBundle).
The MesdPresentationBundle aims to provide a graphical business application layout with
CSS Grids, Jquery, Bootstrap, menus, toolbars, forms, and icons "out of the box".


## Installation of MesdPresentationBundle

Take a look at the bundle [ documentation ](https://github.com/MESD/PresentationBundle).


## Setup to use the MesdPresentationBundle


### Step 1: Set your application user bundle as a child of the `MesdUserBundle`

If you haven't already created your application specific user bundle, that you'll use
to extend the `MesdUserBundle`, do so now and make your user bundle a child of the
`MesdUserBundle`.

``` php
// src/Acme/UserBundle/AcmeUserBundle.php
<?php

namespace Acme\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AcmeUserBundle extends Bundle
{
    public function getParent()
    {
        return 'MesdUserBundle';
    }
}
```


### Step 2: Update your routes

Create a set of security routes within your new application specfic user bundle:

``` yaml
# src/Acme/UserBundle/Resources/config/routing/security.yml
DemoUserBundle_login:
    pattern: /login
    defaults: { _controller: AcmeUserBundle:Security:login }

mesd_user_security_check:
    pattern: /login_check
    defaults: { _controller: MesdUserBundle:Security:check }
    methods:  [POST]

mesd_user_security_logout:
    pattern: /logout
    defaults: { _controller: MesdUserBundle:Security:logout }
```

Next you need to import those routes into your applications routing configuration.

**Note:**

> If you already imported the `MesdUserBundle` routes into your application, you'll need
> to remove the route import lines for the `MesdUserBundle` specefic to security.yml.

``` yaml
# app/config/routing.yml

# Security Routes
AcmeUserBundle_security:
    resource: "@AcmeUserBundle/Resources/config/routing/security.yml"
    prefix: /

```


### Step 3: Update the Security configuration

Update the `security.yml` file for your application. This configuration is similar
to the standard `MesdUserBundle` security configurtion, accept we're removing the
`provider` and specifing a `login_path` that uses your application specific user
bundle route. This allows us to override the controllers, forms, and templates.
Since we're removing the `provider`, we also have to specify a `check_path` that
tells Symfony2 how to  process the form login data the user submits.

**Note**

> Make sure to change the `default_target_path`, under the firewalls -> main directive
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
        mesd_userbundle:
            id: mesd_user.user_provider.username_email

    firewalls:
        dev:
            pattern:  ^/(_(profiler|wdt)|css|images|js|ico)/
            security: false

        login:
            pattern:  ^/(login$|register|resetting)
            anonymous:  true

        main:
            pattern:    ^/
            form_login:
                csrf_provider: form.csrf_provider
                login_path: AcmeUserBundle_login
                check_path: mesd_user_security_check
                default_target_path: place_your_applications_default_route_here
            logout:
                path:   mesd_user_security_logout
                target: AcmeUserBundle_login

    #access_control:
        #- { path: ^/admin, roles: ROLE_ADMIN }
```

### Step 4: Create a new security _controller

You need to create a new security controller in your application specfic user bundle
that will extend the `MesdUserBundle` security controller. This allows us to render
different forms and templates from other bundles.

``` php
<?php
// src/Acme/UserBundle/Controller/SecurityController.php


namespace Acme\UserBundle\Controller;

use Mesd\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;

class SecurityController extends BaseController
{

        /**
         * Renders the login template with the given parameters. Overwrite this function in
         * an extended controller to provide additional data for the login template.
         *
         * @param array $data
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        protected function renderLogin(array $data)
        {
            $template = sprintf('MesdPresentationBundle::login.html.%s', $this->container->getParameter('mesd_user.template.engine'));

            return $this->container->get('templating')->renderResponse($template, $data);
        }

}
```


### Step 5: Update the `MesdPresentationBundle` configuration


``` yaml
# app/config/config.yml

# MESD Presentation Configuration
mesd_presentation:
    login_path:           AcmeUserBundle_login
    login_check_path:     mesd_user_security_check
    logout_path:          mesd_user_security_logout
    user_profile_path:    MesdPresentationBundle_profile
```