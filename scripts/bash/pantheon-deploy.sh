#!/usr/bin/env bash

PROJECT_ROOT="${LANDO_MOUNT}"
BUILD_DIR="$PROJECT_ROOT/build/pantheon"

echo -e "Syncing repo..."
if [ ! -d "$BUILD_DIR" ]; then
  cd "${PROJECT_ROOT}/build" || exit
  git clone "ssh://codeserver.dev.${PANTHEON_SITE_ID}@codeserver.dev.${PANTHEON_SITE_ID}.drush.in:2222/~/repository.git" pantheon
else
  cd "${BUILD_DIR}" || exit
  git pull origin master
fi

# Copy Composer files.
cd "${PROJECT_ROOT}" || exit
cp composer.json "${BUILD_DIR}"
cp composer.lock "${BUILD_DIR}"
cp load.env.php "${BUILD_DIR}"

# Remove build/html from composer path.
cd "${BUILD_DIR}" || exit
sed -i -e "s+build/html+web+" composer.json
sed -i -e "s+build/html+web+" composer.lock
sed -i -e "s+build/drush+drush+g" composer.json
sed -i -e "s+build/drush+drush+g" composer.lock

echo -e "Installing composer dependencies..."
cd "${BUILD_DIR}" || exit
composer install --no-dev

# Copy custom files.
echo -e "Copy custom files..."
rsync -vzhr --delete "${PROJECT_ROOT}/src/config/" "${BUILD_DIR}/config"
rsync -vzhr --delete "${PROJECT_ROOT}/src/profiles/" "${BUILD_DIR}/web/profiles/custom/"
rsync -vzhr --delete "${PROJECT_ROOT}/src/modules/" "${BUILD_DIR}/web/modules/custom/"
rsync -vzhr --delete --exclude '.gitignore' "${PROJECT_ROOT}/src/themes/" "${BUILD_DIR}/web/themes/custom"

# get correct path fot splits.
if [ -f "${BUILD_DIR}/web/libraries/config/default/config_split.config_split.dev.yml" ]; then
  sed -i -e "s+../../src/+../+g" config/default/config_split.config_split.dev.yml
fi
if [ -f "${BUILD_DIR}/web/libraries/config/default/config_split.config_split.prod.yml" ]; then
  sed -i -e "s+../../src/+../+g" config/default/config_split.config_split.prod.yml
fi

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

cd "${PROJECT_ROOT}" || exit
IT=$(git log -1 --pretty=format:"%an, %s - %ai"  $*)
cd "${BUILD_DIR}" || exit
echo -e "Commit and push"
git add .
echo "$IT"
git commit -am "$IT"
git push origin master
