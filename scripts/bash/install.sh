#!/usr/bin/env bash

# Database for the drush command.
DB_URL="mysql://${DATABASE_USER:-drupal8}:${DATABASE_PASSWORD:-drupal8}@${DATABASE_HOST:-database}/${DATABASE_NAME:-drupal8}"

if [ -e "${CONFIG_PATH}/default/system.site.yml" ]; then
  # If config exists, install using it.
  echo "Installing Drupal from the existing configuration."
  drush site:install --db-url="${DB_URL}" --account-pass="admin" "${PROFILE}" --site-name="${PROJECT_NAME}" --existing-config -y
else
  # Otherwise install clean from profile.
  echo "Installing Drupal."
  drush site:install --db-url="${DB_URL}" --account-pass="admin" "${PROFILE}" --site-name="${PROJECT_NAME}" -y
fi
