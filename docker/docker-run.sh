#!/bin/bash
# Unix shell script for Docker operations

case "$1" in
    build)
        echo "Building Docker containers..."
        docker-compose build --no-cache
        ;;
    up)
        echo "Starting Docker containers..."
        docker-compose up -d
        echo ""
        echo "Application is running at: http://localhost:8080"
        ;;
    down)
        echo "Stopping Docker containers..."
        docker-compose down
        ;;
    restart)
        echo "Restarting Docker containers..."
        docker-compose down
        docker-compose up -d
        ;;
    logs)
        echo "Showing logs..."
        docker-compose logs -f
        ;;
    shell)
        echo "Opening shell in app container..."
        docker-compose exec app bash
        ;;
    artisan)
        shift
        echo "Running artisan command..."
        docker-compose exec app php artisan "$@"
        ;;
    fresh)
        echo "Fresh install..."
        docker-compose down -v
        docker-compose build --no-cache
        docker-compose up -d
        echo ""
        echo "Application is running at: http://localhost:8080"
        ;;
    *)
        echo "Usage: ./docker-run.sh [command]"
        echo ""
        echo "Commands:"
        echo "  build    - Build Docker containers"
        echo "  up       - Start containers in background"
        echo "  down     - Stop containers"
        echo "  restart  - Restart containers"
        echo "  logs     - View container logs"
        echo "  shell    - Open shell in app container"
        echo "  artisan  - Run artisan command (e.g., ./docker-run.sh artisan migrate)"
        echo "  fresh    - Fresh install (rebuild everything)"
        ;;
esac

