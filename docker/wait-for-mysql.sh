#!/usr/bin/env bash
# wait-for-it.sh - Wait for a host and TCP port to become available

set -e

TIMEOUT=15
QUIET=0
STRICT=0
HOST=""
PORT=""

usage() {
  echo "Usage: $0 host:port [-t timeout] [--strict] [--quiet]"
  echo "  -t TIMEOUT   Timeout in seconds (default: 15)"
  echo "  --strict     Exit with error if timeout is reached"
  echo "  --quiet      Suppress output"
  exit 1
}

wait_for() {
  for i in $(seq $TIMEOUT); do
    if nc -z "$HOST" "$PORT" >/dev/null 2>&1; then
      [ $QUIET -ne 1 ] && echo "Host $HOST:$PORT is available!"
      return 0
    fi
    sleep 1
  done

  if [ $STRICT -eq 1 ]; then
    [ $QUIET -ne 1 ] && echo "Timeout occurred after waiting $TIMEOUT seconds for $HOST:$PORT"
    return 1
  else
    [ $QUIET -ne 1 ] && echo "Timeout occurred, but continuing anyway."
    return 0
  fi
}

if [ $# -lt 1 ]; then
  usage
fi

while [ $# -gt 0 ]; do
  case "$1" in
    --help)
      usage
      ;;
    --quiet)
      QUIET=1
      shift
      ;;
    --strict)
      STRICT=1
      shift
      ;;
    -t)
      TIMEOUT="$2"
      shift 2
      ;;
    *)
      if [[ "$1" =~ ^[^:]+:[0-9]+$ ]]; then
        HOST=$(echo "$1" | cut -d: -f1)
        PORT=$(echo "$1" | cut -d: -f2)
        shift
      else
        usage
      fi
      ;;
  esac
done

if [ -z "$HOST" ] || [ -z "$PORT" ]; then
  usage
fi

wait_for
