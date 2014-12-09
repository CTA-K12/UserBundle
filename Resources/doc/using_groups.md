##Using the Group capability

The `MesdUserBundle` supports a `Group` feature which allows you to group both
Users and Roles. Each group can contain one or more roles and one one or more
users. The group capabilty can be usefull when your application needs to use
roles as *Permisions* apposed to roles as *User Types*


### Setup to use the MesdUserBundle for use with Groups

#### Step 1: Create your Group class

##### Doctrine ORM Group class

Your `Group` class should live in the `Entity` namespace of your bundle and look like this to
start:

###### Option A) Annotations:

``` php
// src/Acme/UserBundle/Entity/Group.php

namespace Acme\UserBundle\Entity;

use Mesd\UserBundle\Entity\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="acme_group")
 */
class Group extends BaseGroup
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
// src/Acme/UserBundle/Entity/Group.php

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
# src/Acme/UserBundle/Resources/config/doctrine/Group.orm.yml
Acme\UserBundle\Entity\Group:
    type:  entity
    table: acme_group
    id:
        id:
            type: integer
            generator:
                strategy: AUTO

    manyToMany:
        role:
            targetEntity: Role
            joinTable:
                name: acme_group_role
                joinColumns:
                    group_id:
                        referencedColumnName: id
                inverseJoinColumns:
                    role_id:
                        referencedColumnName: id
```



#### Step 2: Update your User class and ORM file, adding the group section to
the exisiting manyToMany section.

``` yaml
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
        role:
            targetEntity: Role
            joinTable:
                name: demo_user_role
                joinColumns:
                    user_id:
                        referencedColumnName: id
                inverseJoinColumns:
                    role_id:
                        referencedColumnName: id
        group:
            targetEntity: Group
            joinTable:
                name: demo_user_group
                joinColumns:
                    user_id:
                        referencedColumnName: id
                inverseJoinColumns:
                    group_id:
                        referencedColumnName: id
```