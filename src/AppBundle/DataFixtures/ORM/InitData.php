<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Configuration;
use AppBundle\Entity\User;

class InitData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $this->loadConfigData($manager);
        $this->loadUserData($manager);
    }

    protected function loadConfigData(ObjectManager $manager)
    {
        $config = new Configuration();
        $config->setWsName('Sunny Flowers');
        $config->setWsTitle('Sunny Flowers');
        $config->setWsSlogan('The biggest choice on the web');
        $config->setWsAddress('123 ABC St, VN');
        $config->setWsPhone('+1 800 9999');
        $config->setWsCopyright('© 2017 SUNNY FLOWERS. ALL RIGHTS RESERVED. DESIGN BY AZ');

        $manager->persist($config);
        $manager->flush();
    }

    protected function loadUserData(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setUsername('hashop');
        $userAdmin->setUsernameCanonical('hashop');
        $userAdmin->setEmail('hashop@hashop.local.com');
        $userAdmin->setEmailCanonical('hashop@hashop.local.com');
        $userAdmin->setEnabled(1);
        $userAdmin->setPassword('$2y$13$azH49/pax74TdhfYijvhyOTgRVKUktGyFNwKKMmU1J3/R42Qv7oQm');
        $userAdmin->setRoles(array('ROLE_SUPER_ADMIN'));

        $manager->persist($userAdmin);
        $manager->flush();
    }
}
