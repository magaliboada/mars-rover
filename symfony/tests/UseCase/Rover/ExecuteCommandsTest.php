<?php

namespace App\Tests\UseCase\Rover;

use App\Entity\Planet;
use App\Entity\Rover;
use App\Model\Coordinate;
use App\UseCase\Rover\ExecuteCommands;
use App\UseCase\Rover\ExecuteCommandsRequest;
use App\UseCase\Rover\ExecuteCommandsResponse;
use PHPUnit\Framework\TestCase;

class ExecuteCommandsTest extends TestCase
{
    private $executeCommands;

    public function testCollisionDetected(): void
    {
        $request = new ExecuteCommandsRequest();
        $request->setRover(new Rover(new Coordinate(0, 0), 'N'));
        $planet = new Planet(5); $planet->setObstacles([new Coordinate(2, 2)]);
        $request->setPlanet($planet);
        $request->setCommands('FFRFFLFF');


        /** @var ExecuteCommandsResponse $response */
        $response = $this->executeCommands->execute($request);
        self::assertFalse($response->isOk());
        self::assertEquals(ExecuteCommands::ROVER_ENCOUNTERED_OBSTACLE, $response->getMessage());
        self::assertTrue($response->isCollisionDetected());
        self::assertEquals(new Coordinate(1, 2), $response->getRoverPosition());
    }

    public function testOutOfBounds(): void
    {
        $request = new ExecuteCommandsRequest();
        $request->setRover(new Rover(new Coordinate(0, 0), 'N'));
        $request->setPlanet(new Planet(3));
        $request->setCommands('FRFLFF');

        /** @var ExecuteCommandsResponse $response */
        $response = $this->executeCommands->execute($request);

        self::assertFalse($response->isOk());
        self::assertEquals(ExecuteCommands::ROVER_OUT_OF_BOUNDS, $response->getMessage());
        self::assertEquals(new Coordinate(1, 2), $response->getRoverPosition());
    }

    public function testMove(): void
    {
        $request = new ExecuteCommandsRequest();
        $request->setRover(new Rover(new Coordinate(0, 0), 'N'));
        $request->setPlanet(new Planet(10));
        $request->setCommands('FFRFFLFFRFF');

        /** @var ExecuteCommandsResponse $response */
        $response = $this->executeCommands->execute($request);
        self::assertEquals(new Coordinate(4, 4), $response->getRoverPosition());
        self::assertFalse($response->isCollisionDetected());
        self::assertTrue($response->isOk());
    }

    public function testStayStill(): void
    {
        $request = new ExecuteCommandsRequest();
        $request->setRover(new Rover(new Coordinate(0, 0), 'S'));
        $request->setPlanet(new Planet(10));
        $request->setCommands('');

        /** @var ExecuteCommandsResponse $response */
        $response = $this->executeCommands->execute($request);
        self::assertEquals(new Coordinate(0, 0), $response->getRoverPosition());
        self::assertFalse($response->isCollisionDetected());
        self::assertTrue($response->isOk());
    }

    public function testNoRoverFound(): void
    {
        $request = new ExecuteCommandsRequest();
        $request->setPlanet(new Planet(10));
        $response = $this->executeCommands->execute($request);

        self::assertFalse($response->isOk());
        self::assertEquals(ExecuteCommands::NO_ROVER_FOUND, $response->getMessage());
    }

    public function testNoPlanetFound(): void
    {
        $request = new ExecuteCommandsRequest();
        $response = $this->executeCommands->execute($request);

        self::assertFalse($response->isOk());
        self::assertEquals(ExecuteCommands::NO_PLANET_FOUND, $response->getMessage());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->executeCommands = new ExecuteCommands();
    }
}
