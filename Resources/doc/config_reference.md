##MesdUserBundle Configuration Reference

Below is a list of all configuration options and their defaults.


```yaml
# app/config/config.yml

mesd_user:
    user_class:             ~ # Required - Your applications user entity class
    role_class:             ~ # Required - Your applications role entity class
    group_class:            ~ # Optional - Your applications group entity class

    login:
        revisit_behavior:        status   # Behavior if user is authenticated - logout | redirect | status
        revisit_redirect_target: ~        # If behavior is redirect, what route should be used
        template:                MesdUserBundle:security:login.html.twig # Login Form template

    registration:
        approval_required:      false                       # Enable Approval Functionality
        approval_mail:          false                       # Send Approval emails to administrator
        approval_mail_from:     webmaster@example.com       # Approval email from address
        approval_mail_subject:  'Account Needs Approval'    # Approval email subject
        enabled:                false                       # Enable Registration Functionality
        link_text:              'Create Account'            # Acount Registration link text on login form
        mail_confirmation:      false                       # Send Confirmation emails to user
        mail_from:              webmaster@example.com       # Confirmation email from address
        mail_subject:           'Account Created'           # Confirmation email subject
        template:                                           # Registration process templates
            confirm:            MesdUserBundle:registration:confirm.html.twig
            register:           MesdUserBundle:registration:register.html.twig
            summary:            MesdUserBundle:registration:summary.html.twig
            approval_mail:      MesdUserBundle:registration:approvalEmail.txt.twig
            confirm_mail:       MesdUserBundle:registration:confirmEmail.txt.twig


    resetting:
        enabled:                false                       # Enable Password Reset Functionality
        link_text:              'Reset Password'            # Password reset link text on login form
        template:
            reset           MesdUserBundle:reset:reset.html.twig
```