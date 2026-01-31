<?php

namespace App\DataFixtures;

use App\Entity\profile;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 1; $i < 71; ++$i)
        {
            $image = new Image();
            $image->setPath("$i.jpg");
            $image->setTitle("cellule-type $i");
            $manager->persist($image);
        }

        $profile = new Profile();
        $profile->setEmail('yassir@gmail.com');
        $profile->setLastName('hakkou');
        $profile->setFirstName('yassir');
        $profile->setCode(1);
        $profile->setPassword('$2y$13$gwq46Lc2PFea.N0esUWqp.nRO9wXYndG7aLkj2f6AhigdmciY2OcS'); // 123456
        $profile->setManageAll(true);
        $manager->persist($profile);

        $manager->flush();
    }
}
