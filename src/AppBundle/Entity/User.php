<?php
/**
 * Created by PhpStorm.
 * User: Konrad
 * Date: 2/25/2016
 * Time: 10:25 AM
 */

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Column
     * @ORM\ID
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\
     */
    protected $orders;

    public function __construct()
    {
        parent::__construct();

    }

}
