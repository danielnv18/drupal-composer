#!/usr/bin/env bash

# Abort if anything fails
set -e

PROJECT_ROOT="${LANDO_MOUNT}"
BUILD_DIR="$PROJECT_ROOT/build/pantheon"

echo -e "Syncing repo..."
if [ ! -d "$BUILD_DIR" ]; then
  cd ${PROJECT_ROOT}/build
  git clone ${PANTHEON_GIT} pantheon
fi

# Copy Composer files.
cd "${PROJECT_ROOT}"
cp composer.json "${BUILD_DIR}"
cp composer.lock "${BUILD_DIR}"
cp load.env.php "${BUILD_DIR}"

# Remove build/html from composer path.
cd "${BUILD_DIR}"
sed -i -e "s/build\/html\//web\//g" composer.json
sed -i -e "s/build\/html\//web\//g" composer.lock
sed -i -e "s/build\/drush/drush/g" composer.json
sed -i -e "s/build\/drush/drush/g" composer.lock


echo -e "Installing composer dependencies..."
cd "${BUILD_DIR}"
composer install --no-dev

# Copy custom files.
echo -e "Copy custom files..."
rsync -vzhr --delete "${PROJECT_ROOT}/src/config/" "${BUILD_DIR}/config"
rsync -vzhr --delete "${PROJECT_ROOT}/src/profiles/" "${BUILD_DIR}/web/profiles/custom/"
rsync -vzhr --delete "${PROJECT_ROOT}/src/modules/" "${BUILD_DIR}/web/modules/custom/"
rsync -vzhr --delete --exclude '.gitignore' "${PROJECT_ROOT}/src/themes/" "${BUILD_DIR}/web/themes/custom"

# Remove .git submodules
echo -e "Removing .git submodules"
cd "${BUILD_DIR}/web/modules/" && find . -name ".git" -exec rm -Rf {} \;
cd "${BUILD_DIR}/web/profiles/" && find . -name ".git" -exec rm -Rf {} \;
if [ -d "${BUILD_DIR}/web/libraries/" ]; then
  cd "${BUILD_DIR}/web/libraries/" && find . -name ".git" -exec rm -Rf {} \;
fi
if [ -d "${BUILD_DIR}/web/themes/" ]; then
  cd "${BUILD_DIR}/web/themes/" && find . -name ".git" -exec rm -Rf {} \;
fi
cd "${BUILD_DIR}/vendor" && find . -name ".git" -exec rm -Rf {} \;
