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
        approval_required:  false
        enabled:            false
        mail_confirmation:  false
        mail_from:          webmaster@example.com
        mail_subject:       'Account Created'
        mail_template:      MesdUserBundle:registration:email.txt.twig
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