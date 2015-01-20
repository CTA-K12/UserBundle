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
        template:                MesdUserBundle:Security:login.html.twig # Login Form template

    registration:
        approval_required:      false                       # Enable Approval Functionality
        approval_mail:          false                       # Send Approval emails to administrator
        approval_mail_from:     webmaster@example.com       # Approval email from address
        approval_mail_subject:  'Account Needs Approval'    # Approval email subject
        approval_mail_to:       ~                           # Approval email to address
        enabled:                false                       # Enable Registration Functionality
        link_text:              'Create Account'            # Acount Registration link text on login form
        mail_confirmation:      false                       # Send Confirmation emails to user
        mail_from:              webmaster@example.com       # Confirmation email from address
        mail_subject:           'Account Created'           # Confirmation email subject
        template:                                           # Registration process templates
            approve:            MesdUserBundle:Registration:approve.html.twig
            confirm:            MesdUserBundle:Registration:confirm.html.twig
            register:           MesdUserBundle:Registration:register.html.twig
            summary:            MesdUserBundle:Registration:summary.html.twig
            approval_mail:      MesdUserBundle:Registration:approvalEmail.txt.twig
            confirm_mail:       MesdUserBundle:Registration:confirmEmail.txt.twig

    resetting:
        enabled:                false                       # Enable Password Reset Functionality
        link_text:              'Reset Password'            # Password reset link text on login form
        mail_from:              webmaster@example.com       # Reset email from address
        mail_subject:           'Account Password Reset'    # Reset email subject
        template:
            already_requested:  MesdUserBundle:Reset:passwordAlreadyRequested.html.twig
            check_email:        MesdUserBundle:Reset:checkEmail.html.twig
            new_password:       MesdUserBundle:Reset:newPassword.html.twig
            request:            MesdUserBundle:Reset:request.html.twig
            reset_mail:         MesdUserBundle:Reset:resetEmail.txt.twig
            success:            MesdUserBundle:Reset:success.html.twig
        token_ttl:              86400                       # Reset token time to live
```