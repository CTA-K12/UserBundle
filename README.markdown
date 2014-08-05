#Mesd/UserBundle

MesdUserBundle is a Symfony2 bundle for managing users and security roles stored in
a Doctrine ORM compatible database.


#Documentation

The documentation can be found in the `Resources/doc` directory:

[Read the Documentation](https://github.com/MESD/UserBundle/blob/master/Resources/doc/index.md)


#Installation

All the installation instructions are located in the documentation.


#License

This bundle is under the MIT license. See the complete license located in:

    Resources/meta/LICENSE


#About

The MesdUserBundle was created based on the design concepts of the [FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle). We original forked the FOSUserBundle to support storing roles in
the database and allowing for a direct database relationship to the user, as well
as adding a few other features. After updating the fork, we began to remove the
non-ORM code to make the code leaner and easier to extend for our purposes. When
it become clear that we were stripping everything back to the Symfony2 Advanced
User Interface implementation, but still had lots of custom DB layer code spread
about needlessly, we decided it would be best to build something from scratch.
However, the design concepts of groups and management services is based on the
work of the FOSUserBundle. If your looking for a user bundle that supports non
ORM implementations, such as Propel, Mongo ODM, or some other custom solution -
you should look at the FOSUserBundle.