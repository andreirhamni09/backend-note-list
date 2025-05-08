#!/bin/sh

echo "⏳ Waiting for MySQL to be ready..."

until mysql -hmysql -ularavel -psecret -e "SELECT 1" > /dev/null 2>&1; do
  sleep 2
done

echo "✅ MySQL is ready!"
