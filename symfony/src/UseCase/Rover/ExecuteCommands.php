<?php

namespace App\UseCase\Rover;

use App\Model\UseCase\UseCaseInterface;
use App\Model\UseCase\UseCaseRequestInterface;
use App\Model\UseCase\UseCaseResponseInterface;

class ExecuteCommands implements UseCaseInterface
{
    public const NO_ROVER_FOUND = 'No rover found';
    public const NO_PLANET_FOUND = 'No planet found';
    const INVALID_COMMAND = 'Invalid command';
    const ROVER_OUT_OF_BOUNDS = 'Rover is out of bounds';
    const ROVER_ENCOUNTERED_OBSTACLE = 'Rover encountered an obstacle';

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

        if($request->getCommands() === '') {
            $response->setRoverPosition($request->getRover()->getPosition());
            $response->setStatus(UseCaseResponseInterface::HTTP_OK);
            return $response;
        }

        $commands = str_split($request->getCommands());
        foreach ($commands as $command) {
            //Save checkpoint in case of collision or out of bounds
            $checkPoint = clone($rover->getPosition());
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
                $response->setRoverPosition($checkPoint);
                return $response;
            }

            if($planet->isObstacle($rover->getPosition())) {
                $response->setMessage(self::ROVER_ENCOUNTERED_OBSTACLE);
                $response->setCollisionDetected(true);
                $response->setRoverPosition($checkPoint);
                return $response;
            }
        }

        $response->setStatus(UseCaseResponseInterface::HTTP_OK);
        $response->setRoverPosition($rover->getPosition());
        return $response;
    }

}
