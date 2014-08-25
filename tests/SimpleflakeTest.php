<?php

namespace Simpleflake\Tests;

use Simpleflake;

class SimpleflakeTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerateShouldNumbersOnly()
    {
        $id = \Simpleflake\generate();
        $this->assertStringMatchesFormat("%d", (string) $id);
    }

    public function testGenerateShouldReturnInt()
    {
        $id = \Simpleflake\generate();
        $this->assertInternalType("integer", $id);
    }

    public function testGenerateResultLength()
    {
        $id = \Simpleflake\generate();
        $length = strlen((string) $id);

        $this->assertGreaterThanOrEqual(19, $length);
    }

    public function testGenerateTimestamp()
    {
        $idA = \Simpleflake\generate(null, 0, 0);
        sleep(1);
        $idB = \Simpleflake\generate(null, 0, 0);

        $this->assertNotEquals($idA, $idB);
    }

    public function testGenerateRandomBits()
    {
        $idA = \Simpleflake\generate(0, null, 0);
        $idB = \Simpleflake\generate(0, null, 0);

        $this->assertNotEquals($idA, $idB);
    }

    public function testFixedDefaultEpoch()
    {
        $idA = \Simpleflake\generate(0, 0);
        $idB = \Simpleflake\generate(0, 0);

        $this->assertNotEquals(0, $idA);
        $this->assertEquals($idA, $idB);
    }

    public function testIdsGrewBigger()
    {
        $idA = \Simpleflake\generate(0);
        $idB = \Simpleflake\generate(1);

        $this->assertGreaterThan($idA, $idB);
    }

    public function testParse()
    {
        $id = 3878068333444056242;
        $parts = \Simpleflake\parse($id);

        $this->assertArrayHasKey("timestamp", $parts);
        $this->assertArrayHasKey("randomBits", $parts);
        $this->assertEquals(1409004570.859, $parts["timestamp"]);
        $this->assertEquals(2081970, $parts["randomBits"]);
    }

    public function testPythonApiNameForGenerate()
    {
        $id = \Simpleflake\simpleflake();
        $this->assertGreaterThan(0, $id);
    }

    public function testPythonApiNameForParse()
    {
        $id = 3878068333444056242;
        $parts = \Simpleflake\parse_simpleflake($id);

        $this->assertArrayHasKey("timestamp", $parts);
        $this->assertArrayHasKey("randomBits", $parts);
        $this->assertEquals(1409004570.859, $parts["timestamp"]);
        $this->assertEquals(2081970, $parts["randomBits"]);
    }
}
