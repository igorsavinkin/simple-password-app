@echo off
REM Windows batch script for Docker operations

IF "%1"=="build" (
    echo Building Docker containers...
    docker-compose build --no-cache
    goto :eof
)

IF "%1"=="up" (
    echo Starting Docker containers...
    docker-compose up -d
    echo.
    echo Application is running at: http://localhost:8080
    goto :eof
)

IF "%1"=="down" (
    echo Stopping Docker containers...
    docker-compose down
    goto :eof
)

IF "%1"=="restart" (
    echo Restarting Docker containers...
    docker-compose down
    docker-compose up -d
    goto :eof
)

IF "%1"=="logs" (
    echo Showing logs...
    docker-compose logs -f
    goto :eof
)

IF "%1"=="shell" (
    echo Opening shell in app container...
    docker-compose exec app bash
    goto :eof
)

IF "%1"=="artisan" (
    echo Running artisan command...
    docker-compose exec app php artisan %2 %3 %4 %5
    goto :eof
)

IF "%1"=="fresh" (
    echo Fresh install...
    docker-compose down -v
    docker-compose build --no-cache
    docker-compose up -d
    echo.
    echo Application is running at: http://localhost:8080
    goto :eof
)

echo Usage: docker-run.bat [command]
echo.
echo Commands:
echo   build    - Build Docker containers
echo   up       - Start containers in background
echo   down     - Stop containers
echo   restart  - Restart containers
echo   logs     - View container logs
echo   shell    - Open shell in app container
echo   artisan  - Run artisan command (e.g., docker-run.bat artisan migrate)
echo   fresh    - Fresh install (rebuild everything)

