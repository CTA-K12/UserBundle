##Using the Filter capability

The `MesdUserBundle` supports a `Filter` feature which allows you to filter a
query based on Users and Roles. Each filter can contains one role and one or
more users. The filter capability can be useful when your application needs to
use roles as *Permissions* as opposed to roles as *User Types*


### Setup to use the MesdUserBundle for use with Filters

#### Step 1: Create your Filter class

##### Doctrine ORM Filter class

Your `Filter` class should live in the `Entity` namespace of your bundle and look like this to
start:

##### Option A) Annotations:

``` php
// src/Acme/UserBundle/Entity/Filter.php

namespace Acme\UserBundle\Entity;

use Mesd\UserBundle\Entity\Filter as BaseFilter;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="acme_filter")
 */
class Filter extends BaseFilter
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="Role", inversedBy="filter")
     * @JoinColumn(name="role_id", referencedColumnName="id")
     **/
    private $role;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="filter")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     **/
    private $user;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
```

``` php
// src/Acme/UserBundle/Entity/User.php

    // your own logic

    /**
     * @OneToMany(targetEntity="Filter", inversedBy="user")
     **/
    private $filter;

    public function __construct()
    {
        parent::__construct();
        $this->filter = new \Doctrine\Common\Collections\ArrayCollection();
        // your own logic
    }
}
```

``` php
// src/Acme/UserBundle/Entity/Role.php

    // your own logic

    /**
     * @OneToMany(targetEntity="Filter", inversedBy="role")
     **/
    private $filter;

    public function __construct()
    {
        parent::__construct();
        $this->filter = new \Doctrine\Common\Collections\ArrayCollection();
        // your own logic
    }
}
```

##### Option B) yaml:

If you use yml to configure Doctrine you must add two files. The Entity and the orm.yml:

```php
<?php
// src/Acme/UserBundle/Entity/Filter.php

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
# src/Acme/UserBundle/Resources/config/doctrine/Filter.orm.yml
Acme\UserBundle\Entity\Filter:
    type:  entity
    table: acme_filter
    id:
        id:
            type: integer
            generator:
                strategy: AUTO

    manyToOne:
        role:
            targetEntity: Role
            inversedBy: filter
            joinColumn:
                name: role_id
                referencedColumnName: id
        user:
            targetEntity: User
            inversedBy: filter
            joinColumn:
                name: user_id
                referencedColumnName: id
```

#### Step 2: Update your User and Role classes

Add the filter section to the existing oneToMany section of your ORM file.

``` yaml
# src/Acme/UserBundle/Resources/config/doctrine/User.orm.yml
Acme\UserBundle\Entity\User:

    // your own logic

    oneToMany:
        filter:
            targetEntity: Filter
            mappedBy: user
```

``` yaml
# src/Acme/UserBundle/Resources/config/doctrine/Role.orm.yml
Acme\UserBundle\Entity\Role:

    // your own logic

    oneToMany:
        filter:
            targetEntity: Filter
            mappedBy: role
```

#### Step 3: Add Filter class to config.yml

Add the `filter_class` configuration to your `config.yml` file:

``` yaml
# app/config/config.yml
mesd_user:
    user_class:   Acme\UserBundle\Entity\User
    role_class:   Acme\UserBundle\Entity\Role
    filter_class: Acme\UserBundle\Entity\Filter
```
