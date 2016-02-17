Provides Postgres Array Type for Doctrine2
-------------------------------------------
Provides Doctrine Type class for postgres array type

#### Using with Zend Framework 2

Add this to `config\autoload\global.php`

    <?php

    return array(
        'doctrine' => array(
            'connection' => array(
                'orm_default' => array(
                 ...
                )
            ),
            'configuration' => array(
                'orm_default' => array(
                    'types' => array(
                        'geometry' => 'YouProjectNamespace\Doctrine\Types\PgArrayType'
                    )
                )
            )
        )
     );

Usage in Entity class

     <?php

     /**
      * Class SuperEntity
      * @Entity
      * @Table(name="super-table")
      */
     class SuperEntity
     {
         /**
          * @var int
          *
          * @Id @Column(type="integer")
          * @GeneratedValue
          */
         private $id;

         /**
          * @var mixed
          *
          * @Column(name="inputs", type="pg_array")
          */
         private $inputs;

#### License

Licensed under the MIT License