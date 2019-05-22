<?php
/********************************
 * Created by ktroufleau.
 * Date: 19/05/2019
 * Time: 15:21
 ********************************/


namespace Anaxago\CoreBundle\DataFixtures\ORM;

use Anaxago\CoreBundle\Entity\User;
use Anaxago\CoreBundle\Entity\Project;
use Anaxago\CoreBundle\Entity\Interest;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class InterestFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $eol = $manager->getRepository(Project::class)->find(3);
        $deux = $manager->getRepository(Project::class)->find(2);

        $john = $manager->getRepository(User::class)->find(1);
        $admin = $manager->getRepository(User::class)->find(2);

        $one = (new Interest())
            ->setAmount('1000')
            ->setProject($eol)
            ->setUsername($john);

        $two = (new Interest())
            ->setAmount('1000')
            ->setProject($deux)
            ->setUsername($john);

        $three = (new Interest())
            ->setAmount('2000')
            ->setProject($eol)
            ->setUsername($admin);

        $manager->persist($one);
        $manager->persist($two);
        $manager->persist($three);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            ProjectFixtures::class,
            UserFixtures::class);
    }
}
