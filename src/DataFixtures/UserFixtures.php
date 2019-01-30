<?php


namespace App\DataFixtures;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Tests\Fixtures\User;


class UserFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setLast_name("mbemba");
        $user->setFirst_name("mbela");
        $user->setEmail("mbela.mbemba@gmail.com");
        $user->setUser_name("mbelacat");
        $user->setRole(["admin"]);
        $user->setPassword($this->passwordEncoder->encodePassword(
          $user,
          'the_new_password'
        ));
        $manager->persist($user);
        $manager->flush();
    }
}
