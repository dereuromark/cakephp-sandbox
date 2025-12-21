#!/bin/bash
#
# Queue Worker Monitor Script
# Sends email alert via SendGrid when queue worker is not running
#
# Usage: Add to crontab (runs every 5 minutes):
#   */5 * * * * /var/www/dereuromark/franken/docker/check_queue.sh
#
# Configuration: Uses same config file as check_memory.sh

# Configuration
SENDGRID_API_KEY=${SENDGRID_API_KEY:-""}
ALERT_EMAIL=${ALERT_EMAIL:-""}
FROM_EMAIL=${FROM_EMAIL:-""}
FROM_NAME=${FROM_NAME:-"Server Monitor"}

# Queue-specific settings
DOCKER_COMPOSE_FILE="/var/www/dereuromark/franken/docker/docker-compose.yml"
QUEUE_CONTAINER="docker-queue-1"
FRANKENPHP_CONTAINER="docker-frankenphp-1"
# Max seconds since last worker activity before alerting
MAX_IDLE_SECONDS=${MAX_IDLE_SECONDS:-300}

# Load config from file parallel to this script
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
CONFIG_FILE="$SCRIPT_DIR/check_queue.conf"
if [ -f "$CONFIG_FILE" ]; then
    source "$CONFIG_FILE"
else
    echo "Error: Config file not found: $CONFIG_FILE"
    exit 1
fi

# Validate required settings
if [ -z "$SENDGRID_API_KEY" ]; then
    echo "Error: SENDGRID_API_KEY not set"
    exit 1
fi

if [ -z "$ALERT_EMAIL" ]; then
    echo "Error: ALERT_EMAIL not set"
    exit 1
fi

if [ -z "$FROM_EMAIL" ]; then
    echo "Error: FROM_EMAIL not set"
    exit 1
fi

# Send email via SendGrid
send_alert() {
    local subject="$1"
    local body="$2"

    # Escape special characters for JSON
    body=$(echo "$body" | sed 's/\\/\\\\/g' | sed 's/"/\\"/g' | sed ':a;N;$!ba;s/\n/\\n/g')

    curl -s --request POST \
        --url https://api.sendgrid.com/v3/mail/send \
        --header "Authorization: Bearer $SENDGRID_API_KEY" \
        --header "Content-Type: application/json" \
        --data "{
            \"personalizations\": [{
                \"to\": [{\"email\": \"$ALERT_EMAIL\"}]
            }],
            \"from\": {
                \"email\": \"$FROM_EMAIL\",
                \"name\": \"$FROM_NAME\"
            },
            \"subject\": \"$subject\",
            \"content\": [{
                \"type\": \"text/plain\",
                \"value\": \"$body\"
            }]
        }"
}

# Check if docker container is running
check_container_running() {
    docker ps --filter "name=$QUEUE_CONTAINER" --filter "status=running" --format "{{.Names}}" | grep -q "$QUEUE_CONTAINER"
}

# Check if container is in restart loop
check_container_restarting() {
    docker ps --filter "name=$QUEUE_CONTAINER" --filter "status=restarting" --format "{{.Names}}" | grep -q "$QUEUE_CONTAINER"
}

# Get queue worker status via CakePHP
get_queue_status() {
    docker exec "$FRANKENPHP_CONTAINER" php /app/bin/cake.php queue info 2>/dev/null
}

# Get active worker count
get_active_workers() {
    get_queue_status | grep "Current running workers:" | awk '{print $NF}'
}

# Get last run timestamp
get_last_activity() {
    get_queue_status | grep "Last run:" | sed 's/Last run: //'
}

# Get container logs (last 20 lines)
get_container_logs() {
    docker logs --tail 20 "$QUEUE_CONTAINER" 2>&1
}

# Main logic
HOSTNAME=$(hostname)
TIMESTAMP=$(date '+%Y-%m-%d %H:%M:%S')
ALERT_NEEDED=false
ALERT_REASON=""

# Check 1: Is container running?
if check_container_restarting; then
    ALERT_NEEDED=true
    ALERT_REASON="Queue container is in a restart loop"
elif ! check_container_running; then
    ALERT_NEEDED=true
    ALERT_REASON="Queue container is not running"
else
    # Check 2: Are there active workers?
    WORKERS=$(get_active_workers)
    if [ -z "$WORKERS" ] || [ "$WORKERS" -eq 0 ]; then
        ALERT_NEEDED=true
        ALERT_REASON="No active queue workers found"
    fi
fi

if [ "$ALERT_NEEDED" = true ]; then
    SUBJECT="[ALERT] Queue Worker Down on $HOSTNAME"
    BODY="Queue worker alert triggered at $TIMESTAMP

Server: $HOSTNAME
Reason: $ALERT_REASON

Container Status:
$(docker ps -a --filter "name=$QUEUE_CONTAINER" --format "table {{.Names}}\t{{.Status}}\t{{.RunningFor}}")

Recent Container Logs:
$(get_container_logs)

Queue Status:
$(get_queue_status 2>&1 || echo "Unable to get queue status")

Please investigate."

    send_alert "$SUBJECT" "$BODY"
    echo "[$TIMESTAMP] Alert sent: $ALERT_REASON"
else
    WORKERS=$(get_active_workers)
    LAST_RUN=$(get_last_activity)
    echo "[$TIMESTAMP] Queue OK: $WORKERS worker(s) active, last run: $LAST_RUN"
fi
