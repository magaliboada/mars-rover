# Mars Rover Mission

### Project Requirements
- You are given the initial starting point (x,y) of a rover and the direction (N,S,E,W) it is facing.
- The rover receives a collection of commands. (E.g.) FFRRFFFRL
- The rover can move forward (f).
- The rover can move left/right (l,r).
- Suppose we are on a really weird planet that is square
- Implement obstacle detection before each move to a new square. If a given sequence of commands encounters an obstacle, 
- the rover moves up to the last possible point, aborts the sequence and reports the obstacle.

### Installing
- docker-compose build
- docker-compose up
- docker-compose exec php shh
- Run composer install
- Visit localhost and follow the instructions

### Testing
Tests can be found inside the following files:
- /tests/Entity/PlanetTest.php
- /tests/Entity/RoverTest.php
- /tests/UseCase/Rover/ExecuteCommandsTest.php

### Stack
- PHP 7.3
- Composer
- Docker
- Symfony 5.1