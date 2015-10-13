<?php
/**
 * Created by Marcus "Loki" Jenz
 * Date: 24.03.14
 * Time: 09:49
 */


//$manager = $this->getContainer()->get('h4cc_alice_fixtures.manager');

// Get a FixtureSet with __default__ options.
$set = new \h4cc\AliceFixturesBundle\Fixtures\FixtureSet();
$set->addFile(__DIR__ . '/fixtures/users.yml', 'yaml');
$set->addFile(__DIR__ . '/fixtures/attributes.yml', 'yaml');
$set->addFile(__DIR__ . '/fixtures/skills.yml', 'yaml');
$set->addFile(__DIR__ . '/fixtures/magicalCapabilities.yml', 'yaml');
$set->addFile(__DIR__ . '/fixtures/traditions.yml', 'yaml');
$set->addFile(__DIR__ . '/fixtures/totems.yml', 'yaml');
$set->addFile(__DIR__ . '/fixtures/characters.yml', 'yaml');
$set->addFile(__DIR__ . '/fixtures/characterToAttributes.yml', 'yaml');
$set->addFile(__DIR__ . '/fixtures/characterToSkills.yml', 'yaml');
$set->addFile(__DIR__ . '/fixtures/connectionsNotInDB.yml', 'yaml');
$set->addFile(__DIR__ . '/fixtures/connectionsInDB.yml', 'yaml');


// Change locale for this set only.
$set->setLocale('de_DE');
// Define a custom random seed for "predictable randomness".
$set->setSeed(42);
// Enable persisting of objects
$set->setDoPersist(true);
// Enable dropping and recreating current ORM schema.
$set->setDoDrop(true);

return $set;