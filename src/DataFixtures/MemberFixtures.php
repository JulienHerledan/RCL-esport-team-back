<?php

namespace App\DataFixtures;

use App\DataFixtures\Abstr\CoreFixture;
use App\Entity\Article;
use App\Entity\Award;
use App\Entity\Competition;
use App\Entity\Game;
use App\Entity\Member;
use App\Entity\SocialNetwork;
use App\Entity\SocialNetworkLink;
use App\Entity\User;
use App\Entity\VideoClip;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MemberFixtures extends CoreFixture implements DependentFixtureInterface
{

  protected function loadFakeData(): void
  {

    $users = $this->manager->getRepository(User::class)->findAll();
    $games = $this->manager->getRepository(Game::class)->findAll();
    $videoClips = $this->manager->getRepository(VideoClip::class)->findAll();

    $this->createMany(Member::class, 5, function (Member $member) use ($users, $games, $videoClips) {
      $member
        ->setCreatedBy($this->faker->randomElement($users))
        ->setUsername($this->faker->userName())
        ->setFirstname($this->faker->firstName())
        ->setLastname($this->faker->lastName())
        ->setPhoto($this->faker->getRandomImageLink(100, 200))
        ->setAge($this->faker->randomNumber(2))
        ->setBiography($this->faker->text(100))
        ->setBirthday($this->faker->dateTime())
        ->setCreatedAt(\DateTimeImmutable::createFromMutable($this->faker->dateTime()));

      for ($i = 1; $i <= 2; $i++) {
        $member->addGame($this->faker->randomElement($games));
      }

      for ($i = 1; $i <= 2; $i++) {
        $member->addVideoClip($this->faker->randomElement($videoClips));
      }
    });
  }

  public function getDependencies(): array
  {
    return array(
      UserFixtures::class,
      GameFixtures::class,
      VideoClipFixtures::class,
    );
  }
}