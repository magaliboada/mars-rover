<?php

namespace App\UseCase\Rover;

use App\Model\Coordinate;
use App\Model\UseCase\UseCaseInterface;
use App\Model\UseCase\UseCaseRequestInterface;
use App\Model\UseCase\UseCaseResponseInterface;

class ExecuteCommands implements UseCaseInterface
{
    public const NO_ROVER_FOUND = 'No rover found';
    public const NO_PLANET_FOUND = 'No planet found';
    public const INVALID_COMMAND = 'Invalid command found';
    public const ROVER_OUT_OF_BOUNDS = 'Rover sent out of bounds';
    public const ROVER_ENCOUNTERED_OBSTACLE = 'Rover encountered an obstacle';
    public const ROVER_MOVED_SUCCESSFULLY = 'Rover moved successfully';
    public const ROVER_STOOD_IN_PLACE = 'Rover stood in place';
    public const ROVER_STARTED_OUT_OF_BOUNDS = 'Rover started out of bounds';

    /**
     * @param UseCaseRequestInterface|ExecuteCommandsRequest $request
     *
     * @return UseCaseResponseInterface
     */
    public function execute(UseCaseRequestInterface $request): UseCaseResponseInterface
    {
        /** @var ExecuteCommandsRequest $createUserRequest */
        $response = new ExecuteCommandsResponse();
        $response->setStatus(UseCaseResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        $response->setCollisionDetected(false);
        $rover = $request->getRover();
        $planet = $request->getPlanet();

        if($planet === null) {
            $response->setMessage(self::NO_PLANET_FOUND);
            return $response;
        }

        if($rover === null) {
            $response->setMessage(self::NO_ROVER_FOUND);
            return $response;
        }

        if(!$planet->isInBounds($rover->getPosition())) {
            $response->setMessage(self::ROVER_STARTED_OUT_OF_BOUNDS);
            $response->setRoverPosition(new Coordinate(0, 0));
            return $response;
        }

        if($request->getCommands() === '') {
            $response->setRoverPosition($request->getRover()->getPosition());
            $response->setMessage(self::ROVER_STOOD_IN_PLACE);
            $response->setStatus(UseCaseResponseInterface::HTTP_OK);
            return $response;
        }

        $commands = str_split(strtoupper($request->getCommands()));
        foreach ($commands as $command) {
            //Save checkpoint in case of collision, out of bounds or invalid command
            $response->setRoverPosition(clone($rover->getPosition()));
            switch ($command) {
                case 'L':
                    $rover->turnLeft();
                    break;
                case 'R':
                    $rover->turnRight();
                    break;
                case 'F':
                    $rover->moveForward();
                    break;
                default:
                    $response->setMessage(self::INVALID_COMMAND);
                    return $response;
            }

            if(!$planet->isInBounds($rover->getPosition())) {
                $response->setMessage(self::ROVER_OUT_OF_BOUNDS);
                return $response;
            }

            if($planet->isObstacle($rover->getPosition())) {
                $response->setMessage(self::ROVER_ENCOUNTERED_OBSTACLE);
                $response->setCollisionDetected(true);
                return $response;
            }
        }

        $response->setMessage(self::ROVER_MOVED_SUCCESSFULLY);
        $response->setStatus(UseCaseResponseInterface::HTTP_OK);
        $response->setRoverPosition($rover->getPosition());
        return $response;
    }

}
