##MesdUserBundle Configuration Reference

Below is a list of all configuration options and their defaults.


```yaml
# app/config/config.yml

mesd_user:
    user_class:             ~ # Required - Your applications user entity class
    role_class:             ~ # Required - Your applications role entity class
    group_class:            ~ # Your applications group entity class

    login:
        template:           MesdUserBundle:security:login.html.twig

    registration:
        enabled:            false
        mailConfirmation:   false
        template:
            confirm:        MesdUserBundle:registration:confirm.html.twig
            register:       MesdUserBundle:registration:register.html.twig
        text:               'Create Account'

    resetting:
        enabled:            false
        template:
            reset           MesdUserBundle:reset:reset.html.twig
        text:               'Reset Password'

```