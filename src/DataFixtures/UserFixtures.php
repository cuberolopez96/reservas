<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public static $USERS = [
        ['Username'=>'admin','Password'=>'admin','roles'=>['ROLE_ADMIN']],
        ['Username' => 'cuberolopez96','Password'=>'chispa34', 'roles'=>['ROLE_USER']]
    ];
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach (self::$USERS as $userdata) {
            $user = new User();
            $user->setUsername($userdata['Username']);
            $user->setPassword($this->encoder->encodePassword($user,$userdata['Password']));
            $user->setRoles($userdata['roles']);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
