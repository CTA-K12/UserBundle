##MesdUserBundle Configuration Reference

Below is a list of all configuration options and their defaults.


```yaml
# app/config/config.yml

mesd_user:
    user_class:             ~ # Required - Your applications user entity class
    role_class:             ~ # Required - Your applications role entity class
    group_class:            ~ # Your applications group entity class

    login:
        revisit_behavior:        status   # Behavior if user is authenticated - logout | redirect | status
        revisit_redirect_target: ~        # If behavior is redirect, what route should be used
        template:                MesdUserBundle:security:login.html.twig # Login Form template

    registration:
        approval_required:  false
        enabled:            false       # Enable/Disable Registration Functionality
        link_text:          'Create Account'
        mail_confirmation:  false
        mail_from:          webmaster@example.com
        mail_subject:       'Account Created'
        mail_template:      MesdUserBundle:registration:email.txt.twig
        template:
            confirm:        MesdUserBundle:registration:confirm.html.twig
            register:       MesdUserBundle:registration:register.html.twig
            summary:        MesdUserBundle:registration:summary.html.twig


    resetting:
        enabled:            false       # Enable/Disable Password Reset Functionality
        link_text:          'Reset Password'
        template:
            reset           MesdUserBundle:reset:reset.html.twig


```